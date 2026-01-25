<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $reviews = Review::all();
        return response()->json($reviews);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'title' => 'required|string',
            'content' => 'required|string',
            'rating' => 'required|integer|min:1|max:5',
        ]);

        $review = Review::create([
            ...$validated,
            'user_id' => auth()->id(),
        ]);

        return response()->json($review, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Review $review): JsonResponse
    {
        return response()->json($review);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Review $review): JsonResponse
    {
        $this->authorize('update', $review);

        $validated = $request->validate([
            'title' => 'string',
            'content' => 'string',
            'rating' => 'integer|min:1|max:5',
        ]);

        $review->update($validated);

        return response()->json($review);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Review $review): JsonResponse
    {
        $this->authorize('delete', $review);

        $review->delete();

        return response()->json(null, 204);
    }
}
