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
use App\Models\Repayment;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Models\RepaymentDetail;
use Illuminate\Support\Facades\DB;
use App\Models\RepaymentCategory;

class RepaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $setup = Setup::init();
        if ($request->ajax()) {
            $data = Repayment::with('repayment_category', 'supplier', 'customer')->latest()->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->editColumn('repayment_category_id', function($row) {
                    return $row->repayment_category ? $row->repayment_category->name : '-'; // Replace repayment_category_id with user name
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
        return view('repayment.index', compact('setup'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $setup = Setup::init();
        $repayment_categories = RepaymentCategory::all();
        $suppliers = Supplier::all();
        $customers = Customer::all();
        $payment_gateways = Account::where("is_payment_gateway", 1)->get();
        return view('repayment.create', compact('setup', 'repayment_categories', 'suppliers', 'customers', 'payment_gateways'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // $repayment_category = RepaymentCategory::findOrFail($request->repayment_category_id) ;
        // $request = self::storeValidate($request);
        // try {
        //     DB::beginRepayment();
        //     $repayment = self::saveHeader($request);
        //     self::saveBody($request, 1, $repayment_category);
        //     self::saveRepaymentToLedger($request, $repayment_category);
        //     self::savePaymentToLedger($request, $repayment_category);
        //     self::updatePayableOrReceivable($request, $repayment_category);
        //     DB::commit();
        //     return redirect()->route('repayment.index')->with('success', 'Repayment successfully created.');
        // } catch (\Exception $e) {
        //     DB::rollBack();
        //     return redirect()->back()->with('fail', 'Failed to create repayment: ' . $e->getMessage());
        // }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $setup = Setup::init();
        $repayment = Repayment::findOrFail($id);
        return view("repayment.show", compact('setup', 'repayment'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Repayment $repayment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Repayment $repayment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // try {
        //     DB::beginRepayment();
        //     $repayment = Repayment::findOrFail($id);
        //     $repayment->repayment_category->deal_with == "suppliers"
        //         ? Supplier::decreasePayable($repayment->supplier_id, $repayment->left)
        //         : Customer::decreaseReceivable($repayment->customer_id, $repayment->left);
        //     foreach($repayment->repayment_detail as $detail){
        //         Material::resetStock($detail->material_id, $detail->repayment->warehouse_id, $detail->repayment->repayment_category->stock_normal_balance_id, $detail->qty);
        //     }
        //     $repayment->delete();
        //     DB::commit();
        //     return redirect()->back()->with("success", "Repayment has been deleted");
        // } catch (\Exception $e) {
        //     DB::rollBack();
        //     return redirect()->back()->with('fail', 'Failed to create repayment: ' . $e->getMessage());
        // }
    }

    public static function storeValidate($request){
        $request->request->add(['user_id' => auth()->id()]);
        $request->validate([
            'id' => 'required|unique:repayments',
            'repayment_category_id' => 'required|exists:repayment_categories,id',
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
        $repayment = Repayment::create([
            'id' => $request->id,
            'repayment_category_id' => $request->repayment_category_id,
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
        return $repayment;
    }

    public static function saveBody($request, $item_order, $repayment_category){
        $stock_normal_balance_id = $repayment_category->stock_normal_balance_id;
        foreach ($request->details as $detail) {
            RepaymentDetail::create([
                'repayment_id' => $request->id,
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

    public static function saveRepaymentToLedger($request, $repayment_category){
        $data = [
            [
                "repayment_id" => $request->id,
                "account_id" => $repayment_category->subtotal_account_id,
                "user_id" => $request->user_id,
                "description" => "{$repayment_category->name} - {$request->id}",
                "debit" => $repayment_category->subtotal_normal_balance_id == "D" ? $request->subtotal : 0,
                "credit" => $repayment_category->subtotal_normal_balance_id == "C" ? $request->subtotal : 0,
            ],
            [
                "repayment_id" => $request->id,
                "account_id" => $repayment_category->taxes_account_id,
                "user_id" => $request->user_id,
                "description" => "{$repayment_category->name} - {$request->id}",
                "debit" => $repayment_category->taxes_normal_balance_id == "D" ? $request->taxes : 0,
                "credit" => $repayment_category->taxes_normal_balance_id == "C" ? $request->taxes : 0,
            ],
            [
                "repayment_id" => $request->id,
                "account_id" => $repayment_category->freight_account_id,
                "user_id" => $request->user_id,
                "description" => "{$repayment_category->name} - {$request->id}",
                "debit" => $repayment_category->freight_normal_balance_id == "D" ? $request->freight : 0,
                "credit" => $repayment_category->freight_normal_balance_id == "C" ? $request->freight : 0,
            ],
            [
                "repayment_id" => $request->id,
                "account_id" => $repayment_category->discount_account_id,
                "user_id" => $request->user_id,
                "description" => "{$repayment_category->name} - {$request->id}",
                "debit" => $repayment_category->discount_normal_balance_id == "D" ? $request->discount : 0,
                "credit" => $repayment_category->discount_normal_balance_id == "C" ? $request->discount : 0,
            ],
            [
                "repayment_id" => $request->id,
                "account_id" => $repayment_category->grand_total_account_id,
                "user_id" => $request->user_id,
                "description" => "{$repayment_category->name} - {$request->id}",
                "debit" => $repayment_category->grand_total_normal_balance_id == "D" ? $request->grand_total : 0,
                "credit" => $repayment_category->grand_total_normal_balance_id == "C" ? $request->grand_total : 0,
            ],
        ];

        $filteredData = array_filter($data, function($entry) {
            return $entry['debit'] != 0 || $entry['credit'] != 0;
        });

        Ledger::insert($filteredData);
    }

    public static function savePaymentToLedger($request, $repayment_category){
        if ($request->payment_gateway_id || $request->paid != 0) {
            Ledger::insert([
                [
                    "repayment_id" => $request->id,
                    "account_id" => $repayment_category->grand_total_account_id,
                    "user_id" => $request->user_id,
                    "description" => "Pembayaran {$repayment_category->name} - {$request->id}",
                    "debit" => $repayment_category->grand_total_normal_balance_id == "C" ? $request->paid : 0,
                    "credit" => $repayment_category->grand_total_normal_balance_id == "D" ? $request->paid : 0,
                ],
                [
                    "repayment_id" => $request->id,
                    "account_id" => $request->payment_gateway_id,
                    "user_id" => $request->user_id,
                    "description" => "Pembayaran {$repayment_category->name} - {$request->id}",
                    "debit" => $repayment_category->grand_total_normal_balance_id == "D" ? $request->paid : 0,
                    "credit" => $repayment_category->grand_total_normal_balance_id == "C" ? $request->paid : 0,
                ],
            ]);
        }
    }

    public static function updatePayableOrReceivable($request, $repayment_category)
    {
        if ($request->left > 0) {
            $repayment_category->deal_with == "suppliers"
                ? Supplier::increasePayable($request->supplier_id, $request->left)
                : Customer::increaseReceivable($request->customer_id, $request->left);
        }
    }

}
