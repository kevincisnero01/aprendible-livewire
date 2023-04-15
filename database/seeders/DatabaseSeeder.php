<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\User;
use App\Models\Article;
use App\Models\Category;
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

        Category::factory(3)->create();

        Article::factory(10)->create();
    }
}
