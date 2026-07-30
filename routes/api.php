<?php

use App\Http\Controllers\ApiPostController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->middleware('auth:sanctum')->group(function () {
    Route::apiResource('posts', [ApiPostController::class]);
});

