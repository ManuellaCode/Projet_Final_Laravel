<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/login', function (Request $request) {
    return response()->json([
        'status' => 'success',
        'message' => 'API is now reachable!',
        'data' => $request->all()
    ]);
});