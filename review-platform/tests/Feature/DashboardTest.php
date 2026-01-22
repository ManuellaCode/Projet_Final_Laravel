<?php

namespace Tests\Feature;

use App\Models\Review;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DashboardTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Créer un utilisateur pour les tests
        $this->user = User::factory()->create();
    }

    /**
     * Test: Récupérer les statistiques du dashboard
     */
    public function test_can_get_dashboard_stats()
    {
        // Créer des avis de test
        Review::factory()->create([
            'user_id' => $this->user->id,
            'sentiment' => 'positive',
            'content' => 'Great product!',
            'score' => 90,
            'topics' => ['quality', 'delivery'],
        ]);

        Review::factory()->create([
            'user_id' => $this->user->id,
            'sentiment' => 'negative',
            'content' => 'Bad experience.',
            'score' => 30,
            'topics' => ['price'],
        ]);

        Review::factory()->create([
            'user_id' => $this->user->id,
            'sentiment' => 'positive',
            'content' => 'Satisfied with the service.',
            'score' => 85,
            'topics' => ['quality', 'service'],
        ]);

        // Appeler l'endpoint
        $response = $this->actingAs($this->user, 'sanctum')
                         ->getJson('/api/dashboard/stats');

        // Vérifications
        $response->assertStatus(200)
                 ->assertJsonStructure([
                     'positive_percentage',
                     'negative_percentage',
                     'neutral_percentage',
                     'average_score',
                     'total_reviews',
                     'sentiment_breakdown',
                     'top_topics',
                     'recent_reviews',
                 ]);

        // Vérifier les valeurs
        $this->assertEquals(3, $response->json('total_reviews'));
        $this->assertTrue($response->json('positive_percentage') > 0);
    }

    /**
     * Test: Vérifier que les top topics sont corrects
     */
    public function test_top_topics_are_calculated_correctly()
    {
        // Créer des avis avec différents topics
        Review::factory()->create([
            'user_id' => $this->user->id,
            'topics' => ['quality', 'delivery'],
        ]);

        Review::factory()->create([
            'user_id' => $this->user->id,
            'topics' => ['quality', 'price'],
        ]);

        Review::factory()->create([
            'user_id' => $this->user->id,
            'topics' => ['quality', 'service'],
        ]);

        $response = $this->actingAs($this->user, 'sanctum')
                         ->getJson('/api/dashboard/stats');

        $topTopics = $response->json('top_topics');
        
        // 'quality' devrait être en premier (apparaît 3 fois)
        $this->assertEquals('quality', $topTopics[0]);
    }

    /**
     * Test: Dashboard avec aucun avis
     */
    public function test_dashboard_with_no_reviews()
    {
        $response = $this->actingAs($this->user, 'sanctum')
                         ->getJson('/api/dashboard/stats');

        $response->assertStatus(200)
                 ->assertJson([
                     'total_reviews' => 0,
                     'average_score' => 0,
                 ]);
    }

    /**
     * Test: Filtre par date
     */
    public function test_can_filter_stats_by_date()
    {
        // Créer un avis ancien
        Review::factory()->create([
            'user_id' => $this->user->id,
            'created_at' => now()->subDays(10),
        ]);

        // Créer un avis récent
        Review::factory()->create([
            'user_id' => $this->user->id,
            'created_at' => now(),
        ]);

        // Filtrer uniquement les avis des 5 derniers jours
        $response = $this->actingAs($this->user, 'sanctum')
                         ->getJson('/api/dashboard/stats?start_date=' . now()->subDays(5)->toDateString());

        $this->assertEquals(1, $response->json('total_reviews'));
    }

    /**
     * Test: Sentiment breakdown
     */
    public function test_sentiment_breakdown()
    {
        Review::factory()->create(['sentiment' => 'positive', 'score' => 90]);
        Review::factory()->create(['sentiment' => 'positive', 'score' => 85]);
        Review::factory()->create(['sentiment' => 'negative', 'score' => 30]);

        $response = $this->actingAs($this->user, 'sanctum')
                         ->getJson('/api/dashboard/sentiment-breakdown');

        $response->assertStatus(200)
                 ->assertJsonStructure([
                     'breakdown' => [
                         '*' => ['sentiment', 'count', 'average_score']
                     ]
                 ]);
    }
}