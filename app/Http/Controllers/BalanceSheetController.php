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

        $account_groups = AccountGroup::where('financial_statement_id', 'B')->get();

        foreach($account_groups as $account_group)
        {
            $account_group->initial_balance = DB::table('accounts')
                ->join('sub_accounts', 'accounts.sub_account_id', '=', 'sub_accounts.id')
                ->join('main_accounts', 'sub_accounts.main_account_id', '=', 'main_accounts.id')
                ->where('main_accounts.account_group_id', $account_group->id)
                ->select(
                    DB::raw('COALESCE(SUM(accounts.initial_balance), 0) AS initial_balance')
                )
                ->pluck('initial_balance')
                ->first();

            $account_group->running_balance = DB::table('accounts')
                ->join('sub_accounts', 'accounts.sub_account_id', '=', 'sub_accounts.id')
                ->join('main_accounts', 'sub_accounts.main_account_id', '=', 'main_accounts.id')
                ->join('account_groups', 'main_accounts.account_group_id', '=', 'account_groups.id')
                ->join('ledgers', 'accounts.id', '=', 'ledgers.account_id')
                ->where('main_accounts.account_group_id', $account_group->id)
                ->whereYear('ledgers.created_at', $year)
                ->whereMonth('ledgers.created_at', $month)
                ->select(
                    DB::raw('COALESCE(SUM(CASE WHEN account_groups.normal_balance_id = "D" THEN (ledgers.debit - ledgers.credit) ELSE (ledgers.credit - ledgers.debit) END), 0) AS running_balance')
                )
                ->pluck('running_balance')
                ->first();

            $account_group->before_balance = DB::table('accounts')
                ->join('sub_accounts', 'accounts.sub_account_id', '=', 'sub_accounts.id')
                ->join('main_accounts', 'sub_accounts.main_account_id', '=', 'main_accounts.id')
                ->join('account_groups', 'main_accounts.account_group_id', '=', 'account_groups.id')
                ->join('ledgers', 'accounts.id', '=', 'ledgers.account_id')
                ->where('main_accounts.account_group_id', $account_group->id)
                ->where('ledgers.created_at', '<', $startDate)
                ->select(
                    DB::raw('COALESCE(
                        SUM(CASE
                            WHEN account_groups.normal_balance_id = "D"
                            THEN (ledgers.debit - ledgers.credit)
                            ELSE (ledgers.credit - ledgers.debit)
                        END),
                        0
                    ) AS before_balance')
                )
                ->pluck('before_balance')
                ->first();

            $account_group->actual_balance = $account_group->initial_balance + $account_group->running_balance - $account_group->before_balance;
        }

        return response()->json(['data' => $account_groups]);
    }
}
