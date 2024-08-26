<?php

namespace App\Http\Controllers;

use App\Models\Ledger;
use App\Models\Journal;
use Illuminate\Http\Request;

class PostingController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        self::resetLedger($request);
        self::pullJournal($request);
        return redirect()->back()->with('success', 'All transaction has been posted successfully.');
    }

    public static function resetLedger($request){
        Ledger::whereBetween('created_at', [$request->start_date, $request->end_date])
            ->delete();
    }

    public static function pullJournal($request){
        $journals = Journal::whereBetween('created_at', [$request->start_date, $request->end_date])->get();
        foreach($journals as $journal){
            foreach($journal->journal_detail as $journal_detail){
                // Ini Penting !!
                if(strpos($journal_detail->description, "Closing") !== false){
                    $is_closing_entry = 1;
                } else {
                    $is_closing_entry = 0;
                }
                Ledger::create([
                    'journal_id' => $journal->id,
                    'account_id' => $journal_detail->account_id,
                    'description' => "{$journal->id} - {$journal_detail->description}",
                    'debit' => $journal_detail->debit,
                    'credit' => $journal_detail->credit,
                    'user_id' => auth()->id(),
                    'is_closing_entry' => $is_closing_entry,
                ]);
            }
        }
    }
}
