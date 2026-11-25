<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Модератор',
            'email' => 'moderator@mail.ru',
            'password' => Hash::make('123456'),
            'role_id' => Role::where('name', 'moderator')->first()->id,
        ]);

        // обычный читатель, чтобы было на ком проверять
        User::create([
            'name' => 'Читатель',
            'email' => 'reader@mail.ru',
            'password' => Hash::make('123456'),
            'role_id' => Role::where('name', 'reader')->first()->id,
        ]);
    }
}
