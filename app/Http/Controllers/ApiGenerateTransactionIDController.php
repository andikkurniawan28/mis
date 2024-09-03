<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Models\TransactionCategory;

class ApiGenerateTransactionIDController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke($transaction_category_id)
    {
        $transactionId = Transaction::generateID($transaction_category_id);
        $transaction_category = TransactionCategory::findOrFail($transaction_category_id);
        return response()->json([
            'transaction_id' => $transactionId,
            'transaction_category' => $transaction_category,
        ]);
    }
}
