<?php

namespace Database\Factories;

use App\Models\Review;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ReviewFactory extends Factory
{
    protected $model = Review::class;

    public function definition()
    {
        return [
            'user_id' => User::factory(),   // ← IMPORTANT
            'sentiment' => 'positive',
            'score' => $this->faker->numberBetween(0, 100),
        ];
    }
}