<?php

use App\Http\Controllers\PostController;
use App\Http\Controllers\PremiumController;
use Illuminate\Support\Facades\Route;

Route::get('/login', function () {
    return response()->json(['message' => 'Unauthenticated.'], 401);
})->name('login');

Route::get('/posts', [PostController::class, 'index']);

Route::get('/posts/{post}', [PostController::class, 'show']);

Route::get('/premium', [premiumController::class, 'index'])
    ->middleware('subscribed');
Route::middleware(['auth', 'verified' ])->group(function () {
    Route::resource('posts', PostController::class)->only([
        'create', 'store', 'edit', 'update', 'destroy'
    ]);
});

