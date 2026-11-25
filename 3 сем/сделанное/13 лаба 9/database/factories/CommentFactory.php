<?php
// ЛР9. accept случайный (80% одобрено), чтобы после сидера было что модерировать.

namespace Database\Factories;

use App\Models\Article;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class CommentFactory extends Factory
{
    public function definition(): array
    {
        return [
            'text' => fake()->realText(150),
            'article_id' => Article::factory(),
            'user_id' => User::inRandomOrder()->first()->id,
            // большая часть уже одобрена, остальные ждут модерации
            'accept' => fake()->boolean(80),
        ];
    }
}
