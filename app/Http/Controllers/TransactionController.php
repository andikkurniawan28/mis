<?php

namespace App\Http\Controllers;

use App\Models\Setup;
use App\Models\TaxRate;
use App\Models\Customer;
use App\Models\Material;
use App\Models\Supplier;
use App\Models\Warehouse;
use App\Models\PaymentTerm;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
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
        return view('transaction.create', compact('setup', 'transaction_categories', 'payment_terms', 'tax_rates', 'warehouses', 'suppliers', 'customers', 'materials'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
    public function destroy(Transaction $transaction)
    {
        //
    }
}
