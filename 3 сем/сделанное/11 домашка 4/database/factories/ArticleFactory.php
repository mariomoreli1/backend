<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ArticleFactory extends Factory
{
    public function definition(): array
    {
        return [
            'date' => fake()->dateTimeBetween('-1 year', 'now')->format('Y-m-d'),
            'name' => fake()->realText(40),
            'short_desc' => fake()->realText(100),
            'desc' => fake()->realText(800),
        ];
    }
}
