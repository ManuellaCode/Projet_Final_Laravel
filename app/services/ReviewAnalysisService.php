<?php

namespace App\Services;

class ReviewAnalysisService
{
    private array $positiveWords = [
        'bon', 'excellent', 'parfait', 'rapide', 'délicieux', 'incroyable'
    ];

    private array $negativeWords = [
        'mauvais', 'lent', 'froid', 'retard', 'horrible', 'déçu'
    ];

    private array $topics = [
        'delivery' => ['livraison', 'livreur', 'retard'],
        'taste' => ['goût', 'délicieux', 'fade'],
        'service' => ['serveur', 'accueil', 'personnel'],
        'speed' => ['rapide', 'lent']
    ];

    public function analyze(string $text): array
    {
        $text = strtolower($text);
        $score = 50;

        // Calcul du score
        foreach ($this->positiveWords as $word) {
            if (str_contains($text, $word)) $score += 10;
        }

        foreach ($this->negativeWords as $word) {
            if (str_contains($text, $word)) $score -= 10;
        }

        $sentiment = match (true) {
            $score >= 60 => 'positive',
            $score <= 40 => 'negative',
            default => 'neutral'
        };

        // Détection des topics
        $detectedTopics = [];
        foreach ($this->topics as $topic => $keywords) {
            foreach ($keywords as $keyword) {
                if (str_contains($text, $keyword)) {
                    $detectedTopics[] = $topic;
                    break;
                }
            }
        }

        return [
            'sentiment' => $sentiment,
            'score' => max(0, min(100, $score)),
            'topics' => array_unique($detectedTopics)
        ];
    }
}

