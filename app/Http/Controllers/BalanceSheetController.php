<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Setup;
use App\Models\Ledger;
use App\Models\Account;
use App\Models\MainAccount;
use App\Models\AccountGroup;
use App\Models\SubAccount;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class BalanceSheetController extends Controller
{
    public function index()
    {
        $setup = Setup::init();
        return view('balance_sheet.index', compact('setup'));
    }

    public function data($year, $month)
    {
        $startDate = Carbon::create($year, $month, 1)->startOfMonth();
        $endDate = Carbon::create($year, $month, 1)->endOfMonth();

        // Ambil semua account group yang berhubungan dengan balance sheet
        $accountGroups = AccountGroup::where('financial_statement_id', 'B')->select('id')->get();
        $main_accounts = MainAccount::whereIn('account_group_id', $accountGroups)->select('id')->get();
        $sub_accounts = SubAccount::whereIn('main_account_id', $main_accounts)->select('id')->get();
        $accounts = Account::whereIn('sub_account_id', $sub_accounts)->get();

        $results = [];

        foreach ($accounts as $account) {
            // Ambil ledger untuk akun ini dalam rentang tanggal yang diminta
            $ledgers = Ledger::where('account_id', $account->id)
                ->whereBetween('created_at', [$startDate, $endDate])
                ->get();

            $initialBalance = $account->initial_balance;
            $debitTotal = $ledgers->sum('debit');
            $creditTotal = $ledgers->sum('credit');

            // Hitung saldo akhir
            if ($account->normal_balance_id == "D") {
                $finalBalance = $initialBalance + $debitTotal - $creditTotal;
            } else {
                $finalBalance = $initialBalance + $creditTotal - $debitTotal;
            }

            // Siapkan data untuk ditampilkan
            $results[] = [
                'account_group_name' => $account->sub_account->main_account->account_group->name,
                'account_name' => $account->name,
                'initial_balance' => $initialBalance,
                'debit' => $debitTotal,
                'credit' => $creditTotal,
                'final_balance' => $finalBalance
            ];
        }

        return response()->json(['data' => $results]);
    }
}
