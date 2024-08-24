<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Setup;
use App\Models\Ledger;
use App\Models\Account;
use App\Models\SubAccount;
use App\Models\MainAccount;
use App\Models\AccountGroup;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;

class BalanceSheetController extends Controller
{
    public function index()
    {
        $setup = Setup::init();
        $account_groups = AccountGroup::where('financial_statement_id', 'B')->get();
        return view('balance_sheet.index', compact('setup', 'account_groups'));
    }

    public function data($year, $month)
    {
        $month = (int)$month;
        $startDate = Carbon::create($year, $month, 1)->startOfMonth();

        $account_groups = AccountGroup::with('main_account.sub_account.account')
            ->where('financial_statement_id', 'B')
            ->get();

        foreach($account_groups as $account_group)
        {
            $account_group->balance_sheet = AccountGroup::balanceSheet($year, $month, $account_group->id, $account_group->normal_balance_id);
            foreach($account_group->main_account as $main_account){
                $main_account->balance_sheet = MainAccount::balanceSheet($year, $month, $main_account->id, $account_group->normal_balance_id);
                foreach($main_account->sub_account as $sub_account){
                    $sub_account->balance_sheet = SubAccount::balanceSheet($year, $month, $sub_account->id, $account_group->normal_balance_id);
                    foreach($sub_account->account as $account){
                        $account->balance_sheet = Account::balanceSheet($year, $month, $account->id, $account_group->normal_balance_id);
                    }
                }
            }
        }

        return response()->json(['data' => $account_groups]);
    }


}
