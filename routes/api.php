<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

//Route::get('/', function (Request $request) {
//    return response()->json([
//        'message' => 'Hello world',
//    ]);
//});

Route::middleware('auth')->get('/', function (Request $request) {
    return response()->json([
        'message' => 'Hello world',
    ]);
});

Route::post('/login', [\App\Http\Controllers\AuthController::class, 'login'])->name('login');

Route::get('/users', [\App\Http\Controllers\AdminController::class, 'users']);
