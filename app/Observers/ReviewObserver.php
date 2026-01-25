<?php

namespace App\Observers;

use App\Models\Review;

class ReviewObserver
{
     public function analyze(Request $request, ReviewAnalysisService $service)
    {
        // Validation du texte
        $request->validate([
            'text' => 'required|string'
        ]);

        // Analyse IA
        $result = $service->analyze($request->text);

        return response()->json($result);
    }
}