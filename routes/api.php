<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\BookController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\TransactionController;
use App\Http\Controllers\Api\DashboardController;
use App\Http\Controllers\Api\CategoryController;

Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {

    Route::post('/logout', [AuthController::class, 'logout']);

    // =====================
    // ADMIN ONLY
    // =====================
    Route::middleware('role:admin')->group(function () {

        Route::get('/dashboard', [DashboardController::class, 'admin']);

        Route::apiResource('books', BookController::class);
        Route::apiResource('users', UserController::class);
        Route::apiResource('categories', CategoryController::class);
    });

    // =====================
    // USER ONLY
    // =====================
    Route::middleware('role:user')->group(function () {
        Route::post('/borrow', [TransactionController::class, 'borrow']);
    });

    // =====================
    // ADMIN & USER
    // =====================
    Route::post('/return/{id}', [TransactionController::class, 'returnBook']);
    Route::get('/transactions', [TransactionController::class, 'index']);
});
