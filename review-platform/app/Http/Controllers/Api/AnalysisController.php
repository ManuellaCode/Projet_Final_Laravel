<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\ReviewAnalysisService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AnalysisController extends Controller
{
    /**
     * Analyze review content using AI
     */
    public function analyze(Request $request, ReviewAnalysisService $analysisService): JsonResponse
    {
        $validated = $request->validate([
            'content' => 'required|string',
        ]);

        $analysis = $analysisService->analyzeReview($validated['content']);

        return response()->json($analysis);
    }
}
