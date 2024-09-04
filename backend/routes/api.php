<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ContactController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('auth/logout', [AuthController::class, 'logout']);

    Route::prefix('contacts')->group(function () {
        Route::post('index', [ContactController::class, 'index']);
        Route::post('store', [ContactController::class, 'store']);
        Route::patch('update/{id}', [ContactController::class, 'update']);
        Route::delete('delete/{id}', [ContactController::class, 'delete']);
    });
});

Route::prefix('auth')->group(function () {
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);
});
