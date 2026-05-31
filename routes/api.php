<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\PaymentOrderController;
use Illuminate\Support\Facades\Route;

// Rutas de autenticación para el login y logout de usuarios
Route::post('/login', [AuthController::class, 'login']);

// Rutas protegidas por autenticación, solo accesibles para usuarios autenticados
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/orders/stats', [PaymentOrderController::class, 'stats']);
    Route::get('/orders', [PaymentOrderController::class, 'index']);
    Route::get('/orders/{id}', [PaymentOrderController::class, 'show']);
});
