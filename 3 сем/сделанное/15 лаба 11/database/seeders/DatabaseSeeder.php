<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\Comment;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
            UserSeeder::class,
        ]);

        // ещё несколько читателей, чтобы у комментариев были разные авторы
        User::factory(3)->create(['role_id' => Role::where('name', 'reader')->first()->id]);

        // 20 статей и у каждой по 3 комментария
        Article::factory(20)->has(Comment::factory(3))->create();
    }
}
