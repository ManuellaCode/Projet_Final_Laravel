<?php

namespace App\Services;

class ReviewAnalysisService
{
    private array $themeMap = [
        'food' => ['nourriture', 'plat', 'repas', 'cuisine', 'goût', 'saveur', 'manger', 'délicieux', 'excellent', 'froid', 'chaud', 'cuisson', 'pizza', 'burger', 'pâtes', 'dessert', 'entrée', 'boisson', 'vin'],
        'service' => ['serveur', 'serveuse', 'accueil', 'personnel', 'staff', 'gentil', 'souriant', 'aimable', 'attente', 'rapide', 'lent', 'parlé', 'réception', 'politesse', 'impoli', 'service'],
        'price' => ['prix', 'cher', 'coût', 'facture', 'addition', 'excessif', 'abordable', 'argent', 'payé', 'tarif', 'euros', '€', 'budget'],
        'ambiance' => ['cadre', 'déco', 'musique', 'bruit', 'bruyant', 'calme', 'propre', 'sale', 'décoration', 'atmosphère', 'lumineux', 'terrasse']
    ];

    /**
     * Analyse un texte ET une note pour retourner sentiment, score et thèmes.
     */
    public function analyze(string $text, int $rating): array
    {
        $textLower = mb_strtolower(trim($text), 'UTF-8');
        
        // --- 1. SCORE DE BASE SELON LES ÉTOILES (La sécurité) ---
        // On donne un score de départ très clair selon les étoiles
        $scoreMap = [
            1 => 10,  // Très négatif
            2 => 30,  // Négatif
            3 => 50,  // Neutre
            4 => 75,  // Positif
            5 => 95   // Très positif
        ];
        
        $score = $scoreMap[$rating] ?? 50;

        // --- 2. AJUSTEMENT SELON LES MOTS ---
        // J'ai ajouté "kiffé", "grave", "top", "aimé" pour ton test
        $positiveWords = ['bien', 'excellent', 'super', 'parfait', 'impeccable', 'top', 'genial', 'génial', 'adoré', 'merci', 'kiffé', 'grave', 'aimé', 'bon'];
        $negativeWords = ['mauvais', 'lent', 'decevant', 'décevant', 'nul', 'pas', 'horrible', 'mal', 'impoli', 'sale', 'catastrophe', 'détesté'];

        foreach ($positiveWords as $word) {
            if (str_contains($textLower, $word)) $score += 10;
        }

        foreach ($negativeWords as $word) {
            if (str_contains($textLower, $word)) $score -= 10;
        }

        // Limite entre 0 et 100
        $score = max(0, min(100, $score));

        // --- 3. SENTIMENT FINAL ---
        if ($score >= 65) {
            $sentiment = 'positive';
        } elseif ($score <= 35) {
            $sentiment = 'negative';
        } else {
            $sentiment = 'neutre';
        }

        // --- 4. THÈMES SÉMANTIQUES ---
        $detectedTopics = [];
        foreach ($this->themeMap as $theme => $keywords) {
            foreach ($keywords as $keyword) {
                if (str_contains($textLower, $keyword)) {
                    $detectedTopics[] = $theme;
                    break;
                }
            }
        }

        if (empty($detectedTopics)) {
            $detectedTopics[] = 'general';
        }

        return [
            'sentiment' => $sentiment,
            'score'     => (int) $score,
            'topics'    => $detectedTopics,
        ];
    }
}