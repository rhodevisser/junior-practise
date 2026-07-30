<?php

use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;
use App\Models\Post;

Route::get('/login', function () {
    return response()->json(['message' => 'Unauthenticated.'], 401);
})->name('login');

Route::get('/posts', function (){
    return view('posts.index');
});
Route::get('/posts/{post}', function (Post $post) {
    return view('posts.show');
});

Route::middleware(['auth', 'verified' ])->group(function () {
    Route::resource('posts', PostController::class)->only([
        'create', 'store', 'edit', 'update', 'destroy'
    ]);
});

