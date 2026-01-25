<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\ReviewAnalysisService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AnalysisController extends Controller
{
    /**
     * Analyser le contenu d'un avis avec l'IA
     * Valide le contenu reçu et le traite via le service d'analyse
     */
    public function analyze(Request $request, ReviewAnalysisService $analysisService): JsonResponse
    {
        // Validation du contenu requis
        $validated = $request->validate([
            'content' => 'required|string',
        ]);

        // Analyse du contenu avec le service d'analyse IA
        $analysis = $analysisService->analyzeReview($validated['content']);

        // Retour de l'analyse en JSON
        return response()->json($analysis);
    }
}
