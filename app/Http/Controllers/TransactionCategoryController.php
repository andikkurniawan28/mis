<?php

namespace App\Http\Controllers;

use App\Models\Setup;
use App\Models\Account;
use Illuminate\Http\Request;
use App\Models\NormalBalance;
use App\Models\TransactionCategory;

class TransactionCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $setup = Setup::init();
        $transaction_categories = TransactionCategory::all();
        return view('transaction_category.index', compact('setup', 'transaction_categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $setup = Setup::init();
        $accounts = Account::all();
        $normal_balances = NormalBalance::all();
        return view('transaction_category.create', compact('setup', 'accounts', 'normal_balances'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            "name" => "required|unique:transaction_categories",
        ]);
        $transaction_category = TransactionCategory::create($validated);
        return redirect()->back()->with("success", "Transaction Category has been created");
    }

    /**
     * Display the specified resource.
     */
    public function show(TransactionCategory $transaction_category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $setup = Setup::init();
        $transaction_category = TransactionCategory::findOrFail($id);
        $accounts = Account::all();
        $normal_balances = NormalBalance::all();
        return view('transaction_category.edit', compact('setup', 'transaction_category', 'accounts', 'normal_balances'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $transaction_category = TransactionCategory::findOrFail($id);
        $validated = $request->validate([
            'name' => 'required|unique:transaction_categories,name,' . $transaction_category->id,
        ]);
        $transaction_category->update($validated);
        return redirect()->route('transaction_category.index')->with("success", "Transaction Category has been updated");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        TransactionCategory::findOrFail($id)->delete();
        return redirect()->back()->with("success", "Transaction Category has been deleted");
    }
}
