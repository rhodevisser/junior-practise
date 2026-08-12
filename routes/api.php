<?php

use App\Http\Controllers\PostController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;



Route::post('/register', [UserController::class, 'register']);

Route::get('/products/featured', [ProductController::class, 'featured']);
Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('posts', PostController::class);
});

