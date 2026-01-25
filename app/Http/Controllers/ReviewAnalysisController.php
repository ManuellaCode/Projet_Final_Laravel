<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReviewAnalysisController extends Controller
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
    }//
}
