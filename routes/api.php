<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AccountController;
use App\Http\Controllers\API\CheckoutController;
use App\Http\Controllers\API\PayoutController;
use App\Http\Controllers\API\ProductController;
use App\Http\Controllers\API\OrderController;
use App\Http\Controllers\API\AuthController;

Route::prefix('v1')->group(function () {

    Route::post('/login', [AuthController::class, 'login']);

    Route::prefix('account')->middleware('auth:sanctum')->group(function () {

        Route::get('/', [AccountController::class, 'show']);

        Route::post('/credit', [AccountController::class, 'credit']);

        Route::get('/ledger', [AccountController::class, 'ledger']);

        Route::get('/orders', [OrderController::class, 'index']);

        Route::post('/payouts', [PayoutController::class, 'store']);
    });

    Route::get('/products', [ProductController::class, 'index']);

    Route::post('/checkout', [CheckoutController::class, 'store']);
});