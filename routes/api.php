<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/', function (Request $request) {
    return response()->json([
        'message' => 'Hello world',
    ]);
});

Route::post('/login', [\App\Http\Controllers\AuthController::class, 'login'])->name('login');
Route::post('/register', [\App\Http\Controllers\AuthController::class, 'register'])->name('register');

Route::controller(\App\Http\Controllers\AdminController::class)->group(function () {
    Route::get('/users', 'users');
});

// Posts
Route::controller(\App\Http\Controllers\PostController::class)->group(function () {
    Route::get('/posts', 'index');
    Route::get('/posts/{slug}', 'show');
    Route::post('/posts', 'create');
    Route::put('/posts/{id}', 'update');
    Route::delete('/posts/{id}', 'destroy');
    Route::get('/posts/{id}/slug', 'showById');
    Route::get('/posts/{id}/comments', 'comments');
});

// Comments
Route::controller(\App\Http\Controllers\CommentController::class)->group(function () {
    Route::get('/comments', 'index');
    Route::get('/comments/{id}', 'show');
    Route::post('/comments/{postId}', 'create');
    Route::put('/comments/{id}', 'update');
    Route::delete('/comments/{id}', 'destroy');

    Route::get('/comments/{id}/post', 'post');
    Route::get('/comments/{id}/user', 'user');
});

