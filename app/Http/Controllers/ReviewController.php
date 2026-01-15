<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReviewController extends Controller
{
      public function index()
    {
        return Review::latest()->get();
    }

    public function show(Review $review)
    {
        return $review;
    }
 public function store(Request $request)
    {
        $request->validate([
            'content' => 'required|string',
            'client_name' => 'nullable|string'
        ]);

        $review = Review::create($request->only('content', 'client_name'));

        return response()->json($review, 201);
    }
public function update(Request $request, Review $review)
    {
        $review->update($request->only('content', 'client_name'));
        return $review;
    }
      public function destroy(Review $review)
    {
        $review->delete();
        return response()->json(['message' => 'Avis supprimé']);
    }
}