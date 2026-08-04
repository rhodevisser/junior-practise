<?php

use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;




Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('posts', PostController::class);
});

