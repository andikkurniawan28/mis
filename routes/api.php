<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiGenerateValidUntilController;
use App\Http\Controllers\ApiGenerateTaxRateInfoController;
use App\Http\Controllers\ApiGenerateMaterialInfoController;
use App\Http\Controllers\ApiGenerateTransactionIDController;
use App\Http\Controllers\ApiGenerateTransactionCategoryInfoController;

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
Route::get("generate_material_info/{material_id}", ApiGenerateMaterialInfoController::class)
    ->name("api.generate_material_info");
Route::get("generate_transaction_category_info/{transaction_category_id}", ApiGenerateTransactionCategoryInfoController::class)
    ->name("api.generate_transaction_category_info");
Route::get("generate_tax_rate_info/{tax_rate_id}", ApiGenerateTaxRateInfoController::class)
    ->name("api.generate_tax_rate_info");
