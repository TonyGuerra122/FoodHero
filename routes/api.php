<?php

use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Product\FavoriteProductController;
use App\Http\Controllers\Product\ProductController;

Route::prefix('auth')->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);

    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/logout', [AuthController::class, 'logout']);
        Route::get('/me', [AuthController::class, 'me']);
        Route::delete('/delete', [AuthController::class, 'delete']);
    });
});

Route::prefix('admin')->middleware(['auth:sanctum', 'role:admin'])->group(function () {
    Route::get('/users', [AdminController::class, 'listUsers']);
    Route::delete('/users/{id}', [AdminController::class, 'deleteUser']);
    Route::put('/users/{id}/promote', [AdminController::class, 'promoteUser']);
    Route::put('/users/{id}/demote', [AdminController::class, 'demoteUser']);
});

Route::prefix('products')->middleware('auth:sanctum')->group(function () {
    Route::get('/', [ProductController::class, 'getAll']);
    Route::get('/{id}/find', [ProductController::class, 'getById']);

    Route::apiResource('favorites', FavoriteProductController::class)
        ->only(['index', 'show', 'store', 'destroy'])
        ->parameters(['favorites' => 'id']);
});
