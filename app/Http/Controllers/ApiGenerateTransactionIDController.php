<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;

class ApiGenerateTransactionIDController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke($transaction_category_id)
    {
        $transactionId = Transaction::generateID($transaction_category_id);
        return response()->json(['transaction_id' => $transactionId]);
    }
}
