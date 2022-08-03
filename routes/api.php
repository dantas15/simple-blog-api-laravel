<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/', function (Request $request) {
    return response()->json([
        'message' => 'Hello world',
    ]);
});

Route::get('users', [\App\Http\Controllers\AdminController::class, 'users']);
