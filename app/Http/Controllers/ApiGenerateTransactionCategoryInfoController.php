<?php

namespace App\Http\Controllers;

use App\Models\TransactionCategory;
use Illuminate\Http\Request;

class ApiGenerateTransactionCategoryInfoController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke($transaction_category_id)
    {
        $transaction_category = TransactionCategory::whereId($transaction_category_id)->get()->last();
        return response()->json(['transaction_category' => $transaction_category]);
    }
}
