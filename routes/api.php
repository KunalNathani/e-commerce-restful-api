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
