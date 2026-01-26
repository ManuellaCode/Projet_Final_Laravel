<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Services\ReviewAnalysisService;

class ReviewController extends Controller
{

    protected $analysisService;

    public function __construct(ReviewAnalysisService $analysisService)
    {
        $this->analysisService = $analysisService;
    }
    /**
     * Afficher la liste de tous les avis
     */
    public function index(): JsonResponse
    {
        // Récupérer tous les avis de la base de données
        $reviews = Review::all();
        return response()->json($reviews);
    }

    /**
     * Créer et stocker un nouvel avis
     * Valide les données et crée l'avis associé à l'utilisateur authentifié
     */
    public function store(Request $request): JsonResponse
    {
        // Valider les données de l'avis
        $validated = $request->validate([
            'content' => 'required|string',
            'rating' => 'required|integer|min:1|max:5',
        ]);

        // Créer l'avis avec les données validées et l'ID de l'utilisateur
        $review = Review::create([
            ...$validated,
            'user_id' => auth()->id(),
        ]);

        //  Analyser le texte via le service
        // Dans ton ReviewController.php
        $analysis = $this->analysisService->analyze($request->content, $request->rating);

        //  Mettre à jour l'avis avec sentiment, score et topics
        $review->update($analysis);


        // Retourner l'avis créé avec le code HTTP 201 (Created)
        return response()->json($review, 201);
    }

    /**
     * Afficher les détails d'un avis spécifique
     */
    public function show(Review $review): JsonResponse
    {
        return response()->json($review);
    }

    /**
     * Mettre à jour un avis existant
     * Vérifier que l'utilisateur a le droit de modifier cet avis
     */
    public function update(Request $request, Review $review): JsonResponse
    {
        // Vérifier l'autorisation de modification
        if ($review->user_id !== $request->user()->id) {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        // Valider les données mises à jour
        $validated = $request->validate([
            'content' => 'string',
            'rating' => 'integer|min:1|max:5',
        ]);

        // Mettre à jour l'avis
        $review->update($validated);

        // Ré-analyser le texte après modification
        $analysis = $this->analysisService->analyze($review->content);
        $review->update($analysis);

        // Retourner l'avis mis à jour en JSON
        return response()->json($review);
    }

    /**
     * Supprimer un avis
     * Vérifier que l'utilisateur a le droit de supprimer cet avis
     */
     public function destroy(Request $request, Review $review)
    {
        if ($review->user_id !== $request->user()->id) {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        $review->delete();

        return response()->json(['message' => 'Avis supprimé']);
    }
}
