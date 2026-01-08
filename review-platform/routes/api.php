<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ReviewController;
use App\Http\Controllers\Api\DashboardController;
use App\Http\Controllers\Api\AnalysisController;

// Routes publiques
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Routes protégées (authentification requise)
Route::middleware('auth:sanctum')->group(function () {

    // Auth
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/user', [AuthController::class, 'user']);

    // Reviews CRUD
    Route::apiResource('reviews', ReviewController::class);

    // Analyse IA
    Route::post('/analyze', [AnalysisController::class, 'analyze']);

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index']);
});