<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\ReviewAnalysisController;

Route::apiResource('reviews', ReviewController::class);
Route::post('/analyze', [ReviewAnalysisController::class, 'analyze']);

