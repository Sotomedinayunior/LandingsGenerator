<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
       

        User::factory()->create([
            'name' => 'test',
            'email' => 'test@example.com',
            'password' => bcrypt('123'), // Asegúrate de usar un hash para la contraseña
            'role' => 'admin',
            'phone' => '123-456-7890',
            'theme' => 'dark', // O cualquier valor que desees
        ]);

        User::factory()->create([
            'name' => 'nelly',
            'email' => 'nelly@gmail.com',
            'password' => bcrypt('1234'), // Asegúrate de usar un hash para la contraseña
            'role' => 'admin',
            'phone' => '456-234-7894',
            'theme' => 'light', // O cualquier valor que desees
        ]);
        User::factory()->create([
            'name' => 'ramphis',
            'email' => 'rhachez@gmail.com',
            'password' => bcrypt('Samuel+Dali+Chezaad+2022#nel'), // Asegúrate de usar un hash para la contraseña
            'role' => 'admin',
            'phone' => '829-675-4531',
            'theme' => 'light', // O cualquier valor que desees
        ]);
    }
}
