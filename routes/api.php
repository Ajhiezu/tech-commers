<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Payment Webhook (Midtrans / Dummy)
Route::post('/webhooks/payment', [\App\Http\Controllers\Api\WebhookController::class, 'handlePayment']);

// Shipping callback
Route::post('/webhooks/shipping', [\App\Http\Controllers\Api\WebhookController::class, 'handleShipping']);
