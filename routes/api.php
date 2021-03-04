<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('login', 'AuthController@login');

Route::apiResource('users', 'UserController')->only(['store']);

Route::middleware('auth:api')->group(function () {
    Route::apiResource('incomes', 'IncomeController');
    Route::apiResource('expenses', 'ExpenseController');
    Route::get('calculateBalance', 'BalanceController');
});
