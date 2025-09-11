<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TravelOrderController;

Route::get('/health', function() {
    return response()->json(['status' => 'OK'], 200);
});

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:api')->group(function () {
    Route::get('/me', [AuthController::class, 'me']);
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::get('/travel-order/list', [TravelOrderController::class, 'index']);
    Route::post('/travel-order', [TravelOrderController::class, 'store']);
    Route::get('/travel-order/{id}', [TravelOrderController::class, 'show']);
    Route::put('/travel-order/{id}/approve', [TravelOrderController::class, 'approve']);
    Route::put('/travel-order/{id}/cancel', [TravelOrderController::class, 'cancel']);
});