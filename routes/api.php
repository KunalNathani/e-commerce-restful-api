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

Route::get('users/verify/{token}', [\App\Http\Controllers\User\UsersController::class, 'verify'])->name('verify');
Route::get('users/{user}/resend', [\App\Http\Controllers\User\UsersController::class, 'resend'])->name('resend');
Route::resource('users', \App\Http\Controllers\User\UsersController::class);
Route::resource('buyers', \App\Http\Controllers\Buyer\BuyersController::class)->only(['index', 'show']);
Route::resource('sellers', \App\Http\Controllers\Seller\SellersController::class)->only(['index', 'show']);
Route::resource('products', \App\Http\Controllers\Product\ProductsController::class)->only(['index', 'show']);
Route::resource('transactions', \App\Http\Controllers\Transaction\TransactionsController::class)->only(['index', 'show']);
Route::resource('transactions.categories', \App\Http\Controllers\Transaction\TransactionCategoryController::class)->only(['index']);
Route::resource('transactions.sellers', \App\Http\Controllers\Transaction\TransactionSellerController::class)->only(['index']);

Route::resource('buyers.transactions', \App\Http\Controllers\Buyer\BuyerTransactionsController::class)->only(['index']);
Route::resource('buyers.products', \App\Http\Controllers\Buyer\BuyerProductsController::class)->only(['index']);
Route::resource('buyers.sellers', \App\Http\Controllers\Buyer\BuyerSellersController::class)->only(['index']);
Route::resource('buyers.categories', \App\Http\Controllers\Buyer\BuyerCategoriesController::class)->only(['index']);

Route::resource('categories.products', \App\Http\Controllers\Category\CategoryProductsController::class)->only(['index']);
Route::resource('categories.sellers', \App\Http\Controllers\Category\CategorySellersController::class)->only(['index']);
Route::resource('categories.transactions', \App\Http\Controllers\Category\CategoryTransactionsController::class)->only(['index']);
Route::resource('categories.buyers', \App\Http\Controllers\Category\CategoryBuyersController::class)->only(['index']);

Route::resource('sellers.categories', \App\Http\Controllers\Seller\SellerCategoriesController::class)->only(['index']);
Route::resource('sellers.buyers', \App\Http\Controllers\Seller\SellerBuyersController::class)->only(['index']);
Route::resource('sellers.products', \App\Http\Controllers\Seller\SellerProductsController::class)->except(['create', 'edit', 'show']);
Route::resource('products.transactions', \App\Http\Controllers\Product\ProductTransactionsController::class)->only(['index']);
Route::resource('products.buyers', \App\Http\Controllers\Product\ProductBuyersController::class)->only(['index']);
Route::resource('products.categories', \App\Http\Controllers\Product\ProductCategoriesController::class)->only(['index', 'update', 'destroy']);
Route::resource('products.buyers.transactions', \App\Http\Controllers\Product\ProductBuyerTransactionsController::class)->only(['index', 'store']);
