<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Obtenir les statistiques du tableau de bord
     * Retourne le nombre total d'avis, la note moyenne et les avis récents de l'utilisateur
     */
    public function index(Request $request): JsonResponse
    {
        // Récupérer l'ID de l'utilisateur authentifié
        $userId = auth()->id();

        // Construire les statistiques du tableau de bord
        $stats = [
            // Nombre total d'avis de l'utilisateur
            'total_reviews' => Review::where('user_id', $userId)->count(),
            // Note moyenne des avis (0 par défaut)
            'average_rating' => Review::where('user_id', $userId)->avg('rating') ?? 0,
            // 5 avis les plus récents de l'utilisateur
            'recent_reviews' => Review::where('user_id', $userId)
                ->latest()
                ->limit(5)
                ->get(),
        ];

        // Retourner les statistiques en JSON
        return response()->json($stats);
    }
}
