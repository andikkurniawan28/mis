<?php

namespace App\Http\Controllers;

use App\Models\Setup;
use App\Models\Ledger;
use App\Models\Account;
use App\Models\TaxRate;
use App\Models\Customer;
use App\Models\Material;
use App\Models\Supplier;
use App\Models\Warehouse;
use App\Models\PaymentTerm;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Models\TransactionDetail;
use Illuminate\Support\Facades\DB;
use App\Models\TransactionCategory;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $setup = Setup::init();
        if ($request->ajax()) {
            $data = Transaction::with('transaction_category', 'user', 'payment_term', 'tax_rate', 'warehouse', 'supplier', 'customer')->latest()->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->editColumn('transaction_category_id', function($row) {
                    return $row->transaction_category ? $row->transaction_category->name : 'N/A'; // Replace transaction_category_id with user name
                })
                ->editColumn('user_id', function($row) {
                    return $row->user ? $row->user->name : 'N/A'; // Replace user_id with user name
                })
                ->editColumn('payment_term_id', function($row) {
                    return $row->payment_term ? $row->payment_term->name : 'N/A'; // Replace payment_term_id with payment_term name
                })
                ->editColumn('tax_rate_id', function($row) {
                    return $row->tax_rate ? $row->tax_rate->name : 'N/A'; // Replace tax_rate_id with tax_rate name
                })
                ->editColumn('warehouse_id', function($row) {
                    return $row->warehouse ? $row->warehouse->name : 'N/A'; // Replace warehouse_id with warehouse name
                })
                ->editColumn('supplier_id', function($row) {
                    return $row->supplier ? $row->supplier->name : 'N/A'; // Replace supplier_id with supplier name
                })
                ->editColumn('customer_id', function($row) {
                    return $row->customer ? $row->customer->name : 'N/A'; // Replace customer_id with customer name
                })
                ->editColumn('created_at', function($row) {
                    return $row->created_at->format('Y-m-d H:i:s'); // Format created_at
                })
                ->make(true);
        }
        return view('transaction.index', compact('setup'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $setup = Setup::init();
        $transaction_categories = TransactionCategory::all();
        $payment_terms = PaymentTerm::all();
        $tax_rates = TaxRate::all();
        $warehouses = Warehouse::all();
        $suppliers = Supplier::all();
        $customers = Customer::all();
        $materials = Material::all();
        $payment_gateways = Account::where("is_payment_gateway", 1)->get();
        return view('transaction.create', compact('setup', 'transaction_categories', 'payment_terms', 'tax_rates', 'warehouses', 'suppliers', 'customers', 'materials', 'payment_gateways'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $transaction_category = TransactionCategory::whereId($request->transaction_category_id)->get()->last();

        // Tambahkan user_id dari user yang sedang login
        $request->request->add(['user_id' => auth()->id()]);

        // Validasi data
        $request->validate([
            'id' => 'required|unique:transactions',
            'transaction_category_id' => 'required|exists:transaction_categories,id',
            'user_id' => 'required|exists:users,id',
            'payment_term_id' => 'required|exists:payment_terms,id',
            'tax_rate_id' => 'required|exists:tax_rates,id',
            'warehouse_id' => 'required|exists:warehouses,id',
            'supplier_id' => 'nullable|exists:suppliers,id',
            'customer_id' => 'nullable|exists:customers,id',
            'valid_until' => 'required|date',
            'subtotal' => 'required|numeric',
            'taxes' => 'required|numeric',
            'freight' => 'required|numeric',
            'discount' => 'required|numeric',
            'grand_total' => 'required|numeric',
            'paid' => 'required|numeric',
            'payment_gateway_id' => 'nullable|exists:accounts,id',
            'details' => 'required|array',
            'details.*.material_id' => 'required|exists:materials,id',
            'details.*.qty' => 'required|numeric',
            'details.*.price' => 'required|numeric',
            'details.*.discount' => 'required|numeric',
            'details.*.total' => 'required|numeric',
        ]);

        try {
            // Mulai transaksi database
            DB::beginTransaction();

            // Simpan data transaction
            $transaction = Transaction::create([
                'id' => $request->id,
                'transaction_category_id' => $request->transaction_category_id,
                'user_id' => $request->user_id,
                'payment_term_id' => $request->payment_term_id,
                'tax_rate_id' => $request->tax_rate_id,
                'warehouse_id' => $request->warehouse_id,
                'supplier_id' => $request->supplier_id,
                'customer_id' => $request->customer_id,
                'valid_until' => $request->valid_until,
                'subtotal' => $request->subtotal,
                'taxes' => $request->taxes,
                'freight' => $request->freight,
                'discount' => $request->discount,
                'grand_total' => $request->grand_total,
            ]);

            // Simpan data transaction details
            $item_order = 1;
            $stock_normal_balance_id = TransactionCategory::whereId($request->transaction_category_id)->get()->last()->stock_normal_balance_id;
            foreach ($request->details as $detail) {
                TransactionDetail::create([
                    'transaction_id' => $request->id, // Menggunakan $transaction->id yang baru disimpan
                    'material_id' => $detail['material_id'],
                    'item_order' => $item_order,
                    'qty' => $detail['qty'],
                    'price' => $detail['price'],
                    'discount' => $detail['discount'],
                    'total' => $detail['total'],
                ]);
                // Atur Stock
                Material::countStock($detail['material_id'], $request->warehouse_id, $stock_normal_balance_id, $detail['qty']);
                $item_order++;
            }

            // Simpan data hutang / piutang ke Supplier / Customer
            if($transaction_category->deal_with == "suppliers") {
                Supplier::increasePayable($request->supplier_id, $request->grand_total);
            } else if($transaction_category->deal_with == "customers") {
                Customer::increaseReceivable($request->customer, $request->grand_total);
            }

            // Simpan data Transaksi ke Buku Besar
            $data = [
                [
                    "transaction_id" => $request->id,
                    "account_id" => $transaction_category->subtotal_account_id,
                    "user_id" => $request->user_id,
                    "description" => "{$transaction_category->name} - {$request->id}",
                    "debit" => $transaction_category->subtotal_normal_balance_id == "D" ? $request->subtotal : 0,
                    "credit" => $transaction_category->subtotal_normal_balance_id == "C" ? $request->subtotal : 0,
                ],
                [
                    "transaction_id" => $request->id,
                    "account_id" => $transaction_category->taxes_account_id,
                    "user_id" => $request->user_id,
                    "description" => "{$transaction_category->name} - {$request->id}",
                    "debit" => $transaction_category->taxes_normal_balance_id == "D" ? $request->taxes : 0,
                    "credit" => $transaction_category->taxes_normal_balance_id == "C" ? $request->taxes : 0,
                ],
                [
                    "transaction_id" => $request->id,
                    "account_id" => $transaction_category->freight_account_id,
                    "user_id" => $request->user_id,
                    "description" => "{$transaction_category->name} - {$request->id}",
                    "debit" => $transaction_category->freight_normal_balance_id == "D" ? $request->freight : 0,
                    "credit" => $transaction_category->freight_normal_balance_id == "C" ? $request->freight : 0,
                ],
                [
                    "transaction_id" => $request->id,
                    "account_id" => $transaction_category->discount_account_id,
                    "user_id" => $request->user_id,
                    "description" => "{$transaction_category->name} - {$request->id}",
                    "debit" => $transaction_category->discount_normal_balance_id == "D" ? $request->discount : 0,
                    "credit" => $transaction_category->discount_normal_balance_id == "C" ? $request->discount : 0,
                ],
                [
                    "transaction_id" => $request->id,
                    "account_id" => $transaction_category->grand_total_account_id,
                    "user_id" => $request->user_id,
                    "description" => "{$transaction_category->name} - {$request->id}",
                    "debit" => $transaction_category->grand_total_normal_balance_id == "D" ? $request->grand_total : 0,
                    "credit" => $transaction_category->grand_total_normal_balance_id == "C" ? $request->grand_total : 0,
                ],
            ];

            // Filter untuk menghapus array dengan nilai debit dan credit 0
            $filteredData = array_filter($data, function($entry) {
                return $entry['debit'] != 0 || $entry['credit'] != 0;
            });

            // Insert ke dalam database
            Ledger::insert($filteredData);

            // Simpan data pelunasan jika ada pelunasan
            if($request->payment_gateway_id != null){
                Ledger::insert([
                    [
                        "transaction_id" => $request->id,
                        "account_id" => $transaction_category->grand_total_account_id,
                        "user_id" => $request->user_id,
                        "description" => "Pembayaran {$transaction_category->name} - {$request->id}",
                        "debit" => $transaction_category->grand_total_normal_balance_id == "C" ? $request->paid : 0,
                        "credit" => $transaction_category->grand_total_normal_balance_id == "D" ? $request->paid : 0,
                    ],
                    [
                        "transaction_id" => $request->id,
                        "account_id" => $request->payment_gateway_id,
                        "user_id" => $request->user_id,
                        "description" => "Pembayaran {$transaction_category->name} - {$request->id}",
                        "debit" => $transaction_category->grand_total_normal_balance_id == "D" ? $request->paid : 0,
                        "credit" => $transaction_category->grand_total_normal_balance_id == "C" ? $request->paid : 0,
                    ],
                ]);
                // Simpan data hutang / piutang ke Supplier / Customer
                if($transaction_category->deal_with == "suppliers") {
                    Supplier::decreasePayable($request->supplier_id, $request->paid);
                } else if($transaction_category->deal_with == "customers") {
                    Customer::decreasePayable($request->customer, $request->paid);
                }
            }

            // Commit transaksi database
            DB::commit();

            // Redirect ke halaman yang sesuai atau berikan respon sukses
            return redirect()->route('transaction.index')->with('success', 'Transaction successfully created.');

        } catch (\Exception $e) {
            // Rollback transaksi jika terjadi error
            DB::rollBack();

            // Redirect dengan menampilkan pesan error spesifik
            return redirect()->back()->withErrors(['error' => 'Failed to create transaction: ' . $e->getMessage()]);
        }
    }



    /**
     * Display the specified resource.
     */
    public function show(Transaction $transaction)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Transaction $transaction)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Transaction $transaction)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $transaction = Transaction::findOrFail($id);
        $transaction_details = TransactionDetail::where('transaction_id', $id)->get();
        foreach($transaction_details as $detail){
            Material::resetStock($detail->material_id, $detail->transaction->warehouse_id, $detail->transaction->transaction_category->stock_normal_balance_id, $detail->qty);
        }
        Transaction::findOrFail($id)->delete();
        return redirect()->back()->with("success", "Transaction has been deleted");
    }
}
