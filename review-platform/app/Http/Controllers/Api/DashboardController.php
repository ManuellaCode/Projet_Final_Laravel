<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function stats()
    {
        try {
            $total = Review::count();

            if ($total === 0) {
                return response()->json([
                    'positive' => 0,
                    'negative' => 0,
                    'neutral' => 0,
                    'average_score' => 0,
                    'top_topics' => [],
                    'recent_reviews' => []
                ]);
            }

            // 1. Comptage par sentiment (Requis par le projet)
            $positive = Review::where('sentiment', 'positive')->count();
            $negative = Review::where('sentiment', 'negative')->count();
            $neutral  = Review::where('sentiment', 'neutral')->count();

            // 2. Moyenne des scores (Correction: 'score' au lieu de 'rating')
            $average_score = Review::avg('score');

            // 3. Top 3 thèmes (Extraction propre du JSON)
            $topics = Review::pluck('topics')->flatten()->filter();
            $top_topics = $topics->countBy()
                ->sortDesc()
                ->take(3)
                ->keys()
                ->toArray();

            // 4. 5 avis les plus récents (Avec auteur)
            $recent_reviews = Review::with('user:id,name')
                ->latest()
                ->take(5)
                ->get();

            return response()->json([
                'positive' => round(($positive / $total) * 100, 1),
                'negative' => round(($negative / $total) * 100, 1),
                'neutral'  => round(($neutral / $total) * 100, 1),
                'average_score' => round($average_score, 1),
                'top_topics' => $top_topics,
                'recent_reviews' => $recent_reviews
            ]);
        } catch (\Exception $e) {
            // Si ça plante encore, Postman affichera l'erreur précise ici
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}