<?php

use Illuminate\Http\Request;
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

Route::resource('users', \App\Http\Controllers\User\UsersController::class);
Route::resource('buyers', \App\Http\Controllers\Buyer\BuyersController::class)->only(['index', 'show']);
Route::resource('sellers', \App\Http\Controllers\Seller\SellersController::class)->only(['index', 'show']);
Route::resource('products', \App\Http\Controllers\Product\ProductsController::class)->only(['index', 'show']);
Route::resource('transactions', \App\Http\Controllers\Transaction\TransactionsController::class)->only(['index', 'show']);
Route::resource('transactions.categories', \App\Http\Controllers\Transaction\TransactionCategoryController::class)->only(['index']);
Route::resource('transactions.sellers', \App\Http\Controllers\Transaction\TransactionSellerController::class)->only(['index']);
Route::resource('buyers.transactions', \App\Http\Controllers\Buyer\BuyerTransactionsController::class)->only(['index']);
