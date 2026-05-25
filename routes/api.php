<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\API\CategoryController;
use App\Http\Controllers\API\ProductController;
use App\Http\Controllers\API\OrderController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

// ============================================================
// AUTH (public - tanpa token)
// ============================================================
Route::prefix('auth')->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login',    [AuthController::class, 'login']);
});

// ============================================================
// AUTH (protected - butuh token)
// ============================================================
Route::prefix('auth')->middleware('auth:sanctum')->group(function () {
    Route::post('/logout',  [AuthController::class, 'logout']);
    Route::get('/profile',  [AuthController::class, 'profile']);
});

// ============================================================
// D.2 KATEGORI PRODUK
// ============================================================
Route::get('/categories',      [CategoryController::class, 'index']);
Route::get('/categories/{id}', [CategoryController::class, 'show']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/categories',        [CategoryController::class, 'store']);
    Route::put('/categories/{id}',    [CategoryController::class, 'update']);
    Route::delete('/categories/{id}', [CategoryController::class, 'destroy']);
});

// ============================================================
// D.3 PRODUK
// ============================================================
Route::get('/products',      [ProductController::class, 'index']);
Route::get('/products/{id}', [ProductController::class, 'show']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/products',               [ProductController::class, 'store']);
    Route::put('/products/{id}',           [ProductController::class, 'update']);
    Route::patch('/products/{id}/toggle',  [ProductController::class, 'toggle']);
    Route::delete('/products/{id}',        [ProductController::class, 'destroy']);
});

// ============================================================
// D.4 PESANAN (ORDERS)
// ============================================================
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/orders',                  [OrderController::class, 'index']);
    Route::post('/orders',                 [OrderController::class, 'store']);
    Route::get('/orders/{id}',             [OrderController::class, 'show']);
    Route::patch('/orders/{id}/status',    [OrderController::class, 'updateStatus']);
});