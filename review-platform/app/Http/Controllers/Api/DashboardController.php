<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Get dashboard statistics
     */
    public function index(Request $request): JsonResponse
    {
        $userId = auth()->id();

        $stats = [
            'total_reviews' => Review::where('user_id', $userId)->count(),
            'average_rating' => Review::where('user_id', $userId)->avg('rating') ?? 0,
            'recent_reviews' => Review::where('user_id', $userId)
                ->latest()
                ->limit(5)
                ->get(),
        ];

        return response()->json($stats);
    }
}
