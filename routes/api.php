<?php

namespace App\Http\Controllers;

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

/** Routes for user authentication */

Route::controller(LoginController::class)->group(function () {
    Route::get('/login', 'notLoggedin')->name('login');
    Route::post('/login', 'login');
    Route::post('/logout', 'logout')->middleware('auth:sanctum');
});

/**      end-authentication      */


Route::resource('pageContents', PageContentsController::class);
Route::resource('donations', DonationController::class);

Route::controller(PaymentController::class)->group(function () {
    Route::post('/pay/oneTime', 'oneTimePayment');
    Route::post('/pay/confirm', 'confirmPayment');
    Route::post('/pay/monthly/{client}/{customer}', 'recurringPayment');
});

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/user', [LoginController::class, 'user']);
});

