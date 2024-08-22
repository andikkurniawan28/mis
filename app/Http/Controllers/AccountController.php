<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\SubAccount;
use App\Models\NormalBalance;
use App\Models\Setup;
use Illuminate\Http\Request;

class AccountController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $setup = Setup::init();
        $accounts = Account::all();
        return view('account.index', compact('setup', 'accounts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $setup = Setup::init();
        $sub_accounts = SubAccount::all();
        $normal_balances = NormalBalance::all();
        return view('account.create', compact('setup', 'sub_accounts', 'normal_balances'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            "id" => "required|unique:accounts",
            "name" => "required|unique:accounts",
            "sub_account_id" => "required",
            "normal_balance_id" => "required",
            "initial_balance" => "required",
        ]);
        $account = Account::create($validated);
        return redirect()->back()->with("success", "Account has been created");
    }

    /**
     * Display the specified resource.
     */
    public function show(Account $account)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $setup = Setup::init();
        $account = Account::findOrFail($id);
        $sub_accounts = SubAccount::all();
        $normal_balances = NormalBalance::all();
        return view('account.edit', compact('setup', 'account', 'sub_accounts', 'normal_balances'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $account = Account::findOrFail($id);
        $validated = $request->validate([
            'id' => 'required|unique:accounts,id,' . $account->id,
            'name' => 'required|unique:accounts,name,' . $account->id,
            "sub_account_id" => "required",
            "normal_balance_id" => "required",
            "initial_balance" => "required",
        ]);
        $account->update($validated);
        return redirect()->route('account.index')->with("success", "Account has been updated");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        Account::findOrFail($id)->delete();
        return redirect()->back()->with("success", "Account has been deleted");
    }
}
