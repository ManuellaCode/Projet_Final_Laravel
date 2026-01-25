<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
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
            'title' => 'required|string',
            'content' => 'required|string',
            'rating' => 'required|integer|min:1|max:5',
        ]);

        // Créer l'avis avec les données validées et l'ID de l'utilisateur
        $review = Review::create([
            ...$validated,
            'user_id' => auth()->id(),
        ]);

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
        $this->authorize('update', $review);

        // Valider les données mises à jour
        $validated = $request->validate([
            'title' => 'string',
            'content' => 'string',
            'rating' => 'integer|min:1|max:5',
        ]);

        // Mettre à jour l'avis
        $review->update($validated);

        // Retourner l'avis mis à jour en JSON
        return response()->json($review);
    }

    /**
     * Supprimer un avis
     * Vérifier que l'utilisateur a le droit de supprimer cet avis
     */
    public function destroy(Review $review): JsonResponse
    {
        // Vérifier l'autorisation de suppression
        $this->authorize('delete', $review);

        // Supprimer l'avis
        $review->delete();

        // Retourner une réponse vide avec le code HTTP 204 (No Content)
        return response()->json(null, 204);
    }
}
