<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\DashboardStatsRequest;
use App\Models\Review;
use Illuminate\Http\JsonResponse;

class DashboardController extends Controller
{
    public function stats(): JsonResponse
    {
        try {
            $totalReviews = Review::count();

            if ($totalReviews === 0) {
                return response()->json([
                    'positive_percentage' => 0,
                    'negative_percentage' => 0,
                    'neutral_percentage' => 0,
                    'average_score' => 0,
                    'top_topics' => [],
                    'recent_reviews' => [],
                    'total_reviews' => 0,
                ]);
            }

            $positiveCount = Review::positive()->count();
            $negativeCount = Review::negative()->count();
            $neutralCount = Review::neutral()->count();

            $positivePercentage = round(($positiveCount / $totalReviews) * 100, 2);
            $negativePercentage = round(($negativeCount / $totalReviews) * 100, 2);
            $neutralPercentage = round(($neutralCount / $totalReviews) * 100, 2);

            $averageScore = round(Review::avg('score') ?? 0, 2);

            $topTopics = $this->getTopTopics(3);

            $recentReviews = Review::with('user:id,name,email')
                ->orderBy('created_at', 'desc')
                ->limit(10)
                ->get()
                ->map(function ($review) {
                    return [
                        'id' => $review->id,
                        'content' => $review->content,
                        'sentiment' => $review->sentiment,
                        'score' => $review->score,
                        'topics' => $review->topics ?? [],
                        'user' => [
                            'id' => $review->user->id ?? null,
                            'name' => $review->user->name ?? 'Anonyme',
                        ],
                        'created_at' => $review->created_at->format('Y-m-d H:i:s'),
                    ];
                });

            return response()->json([
                'positive_percentage' => $positivePercentage,
                'negative_percentage' => $negativePercentage,
                'neutral_percentage' => $neutralPercentage,
                'average_score' => $averageScore,
                'top_topics' => $topTopics,
                'recent_reviews' => $recentReviews,
                'total_reviews' => $totalReviews,
                'stats_by_sentiment' => [
                    'positive' => $positiveCount,
                    'negative' => $negativeCount,
                    'neutral' => $neutralCount,
                ],
                'score_distribution' => $this->getScoreDistribution(),
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Erreur lors de la récupération des statistiques',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    private function getTopTopics(int $limit = 3): array
    {
        $reviews = Review::whereNotNull('topics')
            ->where('topics', '!=', '[]')
            ->get();

        $topicCounts = [];

        foreach ($reviews as $review) {
            $topics = $review->topics ?? [];

            if (is_array($topics)) {
                foreach ($topics as $topic) {
                    if (!empty($topic)) {
                        $topicCounts[$topic] = ($topicCounts[$topic] ?? 0) + 1;
                    }
                }
            }
        }

        arsort($topicCounts);

        $topTopics = array_slice($topicCounts, 0, $limit, true);

        $result = [];
        foreach ($topTopics as $topic => $count) {
            $result[] = [
                'topic' => $topic,
                'count' => $count,
                'percentage' => round(($count / max($reviews->count(), 1)) * 100, 2),
            ];
        }

        return $result;
    }

    private function getScoreDistribution(): array
    {
        return [
            '0-20' => Review::whereBetween('score', [0, 20])->count(),
            '21-40' => Review::whereBetween('score', [21, 40])->count(),
            '41-60' => Review::whereBetween('score', [41, 60])->count(),
            '61-80' => Review::whereBetween('score', [61, 80])->count(),
            '81-100' => Review::whereBetween('score', [81, 100])->count(),
        ];
    }

    public function filteredStats(DashboardStatsRequest $request): JsonResponse
    {
        $query = Review::query();

        if ($request->filled('sentiment') && in_array($request->sentiment, ['positive', 'negative', 'neutral'])) {
            $query->where('sentiment', $request->sentiment);
        }

        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        if ($request->filled('min_score')) {
            $query->where('score', '>=', $request->min_score);
        }

        if ($request->filled('max_score')) {
            $query->where('score', '<=', $request->max_score);
        }

        $totalReviews = $query->count();

        if ($totalReviews === 0) {
            return response()->json([
                'message' => 'Aucun avis trouvé avec ces critères',
                'stats' => null,
            ], 200);
        }

        $positiveCount = (clone $query)->where('sentiment', 'positive')->count();
        $negativeCount = (clone $query)->where('sentiment', 'negative')->count();
        $neutralCount = (clone $query)->where('sentiment', 'neutral')->count();

        return response()->json([
            'total_reviews' => $totalReviews,
            'positive_percentage' => round(($positiveCount / $totalReviews) * 100, 2),
            'negative_percentage' => round(($negativeCount / $totalReviews) * 100, 2),
            'neutral_percentage' => round(($neutralCount / $totalReviews) * 100, 2),
            'average_score' => round($query->avg('score') ?? 0, 2),
            'filters_applied' => $request->only([
                'sentiment',
                'date_from',
                'date_to',
                'min_score',
                'max_score'
            ]),
        ], 200);
    }
}
