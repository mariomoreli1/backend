<?php
# Сидер создаёт 20 новостей. Запуск: php artisan migrate:fresh --seed.
namespace Database\Seeders;

use App\Models\Article;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        Article::factory(20)->create();
    }
}
