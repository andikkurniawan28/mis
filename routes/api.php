<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiGenerateValidUntilController;
use App\Http\Controllers\ApiGenerateTransactionIDController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::get("generate_transaction_id/{transaction_category_id}", ApiGenerateTransactionIDController::class)
    ->name("api.generate_transaction_id");
Route::get("generate_valid_until/{payment_term_id}/{current_date}", ApiGenerateValidUntilController::class)
    ->name("api.generate_valid_until");
