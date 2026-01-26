<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Review;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Créer un admin
        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password123'),
            'role' => 'admin',
        ]);

        // 2. Créer un utilisateur normal
        $user = User::create([
            'name' => 'John Doe',
            'email' => 'user@example.com',
            'password' => Hash::make('password123'),
            'role' => 'user',
        ]);

        // 3. Créer quelques avis de test
        Review::create([
            'user_id' => $user->id,
            'content' => 'Excellent service, livraison rapide et produit de qualité !',
            'sentiment' => 'positive',
            'score' => 92,
            'topics' => ['delivery', 'quality', 'service'],
        ]);

        Review::create([
            'user_id' => $user->id,
            'content' => 'Très déçu, le produit est arrivé endommagé.',
            'sentiment' => 'negative',
            'score' => 35,
            'topics' => ['quality', 'delivery'],
        ]);

        Review::create([
            'user_id' => $admin->id,
            'content' => 'C\'est correct, rien d\'exceptionnel mais le prix est bon.',
            'sentiment' => 'neutral',
            'score' => 65,
            'topics' => ['price'],
        ]);

        // Optionnel : Appeler d'autres seeders si nécessaire
        // $this->call([ UserSeeder::class ]);
    }
}