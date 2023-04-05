<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\User;
use App\Models\Article;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory(3)->create();
        User::factory()->create([
            'name' => 'kevin',
            'email' => 'kevin@gmail.com',
        ]);

        Article::factory(10)->create();
    }
}
