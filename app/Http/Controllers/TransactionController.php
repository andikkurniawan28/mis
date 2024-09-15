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
                    return $row->transaction_category ? $row->transaction_category->name : '-'; // Replace transaction_category_id with user name
                })
                ->editColumn('user_id', function($row) {
                    return $row->user ? $row->user->name : '-'; // Replace user_id with user name
                })
                ->editColumn('payment_term_id', function($row) {
                    return $row->payment_term ? $row->payment_term->name : '-'; // Replace payment_term_id with payment_term name
                })
                ->editColumn('tax_rate_id', function($row) {
                    return $row->tax_rate ? $row->tax_rate->name : '-'; // Replace tax_rate_id with tax_rate name
                })
                ->editColumn('warehouse_id', function($row) {
                    return $row->warehouse ? $row->warehouse->name : '-'; // Replace warehouse_id with warehouse name
                })
                ->editColumn('supplier_id', function($row) {
                    return $row->supplier ? $row->supplier->name : '-'; // Replace supplier_id with supplier name
                })
                ->editColumn('customer_id', function($row) {
                    return $row->customer ? $row->customer->name : '-'; // Replace customer_id with customer name
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
        $transaction_category = TransactionCategory::findOrFail($request->transaction_category_id) ;
        $request = self::storeValidate($request);
        try {
            DB::beginTransaction();
            $transaction = self::saveHeader($request);
            self::saveBody($request, 1, $transaction_category);
            self::saveTransactionToLedger($request, $transaction_category);
            self::savePaymentToLedger($request, $transaction_category);
            self::updatePayableOrReceivable($request, $transaction_category);
            DB::commit();
            return redirect()->route('transaction.index')->with('success', 'Transaction successfully created.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('fail', 'Failed to create transaction: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $setup = Setup::init();
        $transaction = Transaction::findOrFail($id);
        return view("transaction.show", compact('setup', 'transaction'));
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
        try {
            DB::beginTransaction();
            $transaction = Transaction::findOrFail($id);
            $transaction->transaction_category->deal_with == "suppliers"
                ? Supplier::decreasePayable($transaction->supplier_id, $transaction->left)
                : Customer::decreaseReceivable($transaction->customer_id, $transaction->left);
            foreach($transaction->transaction_detail as $detail){
                Material::resetStock($detail->material_id, $detail->transaction->warehouse_id, $detail->transaction->transaction_category->stock_normal_balance_id, $detail->qty);
            }
            $transaction->delete();
            DB::commit();
            return redirect()->back()->with("success", "Transaction has been deleted");
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('fail', 'Failed to create transaction: ' . $e->getMessage());
        }
    }

    public static function storeValidate($request){
        $request->request->add(['user_id' => auth()->id()]);
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
            'left' => 'required|numeric',
            'payment_gateway_id' => 'nullable|exists:accounts,id',
            'details' => 'required|array',
            'details.*.material_id' => 'required|exists:materials,id',
            'details.*.qty' => 'required|numeric',
            'details.*.price' => 'required|numeric',
            'details.*.discount' => 'required|numeric',
            'details.*.total' => 'required|numeric',
        ]);
        return $request;
    }

    public static function saveHeader($request){
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
            'paid' => $request->paid,
            'left' => $request->left,
            'payment_gateway_id' => $request->payment_gateway_id,
        ]);
        return $transaction;
    }

    public static function saveBody($request, $item_order, $transaction_category){
        $stock_normal_balance_id = $transaction_category->stock_normal_balance_id;
        foreach ($request->details as $detail) {
            TransactionDetail::create([
                'transaction_id' => $request->id,
                'material_id' => $detail['material_id'],
                'item_order' => $item_order,
                'qty' => $detail['qty'],
                'price' => $detail['price'],
                'discount' => $detail['discount'],
                'total' => $detail['total'],
            ]);
            Material::countStock($detail['material_id'], $request->warehouse_id, $stock_normal_balance_id, $detail['qty']);
            $item_order++;
        }
    }

    public static function saveTransactionToLedger($request, $transaction_category){
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

        $filteredData = array_filter($data, function($entry) {
            return $entry['debit'] != 0 || $entry['credit'] != 0;
        });

        Ledger::insert($filteredData);
    }

    public static function savePaymentToLedger($request, $transaction_category){
        if ($request->payment_gateway_id || $request->paid != 0) {
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
        }
    }

    public static function updatePayableOrReceivable($request, $transaction_category)
    {
        if ($request->left > 0) {
            $transaction_category->deal_with == "suppliers"
                ? Supplier::increasePayable($request->supplier_id, $request->left)
                : Customer::increaseReceivable($request->customer_id, $request->left);
        }
    }

}
