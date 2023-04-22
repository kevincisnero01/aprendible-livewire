<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Article>
 */
class ArticleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $sentence = fake()->unique()->sentence();
        
        return [
            //'image' => fake()->imageUrl(640,480,null),
            'title' => $sentence,
            'slug' => Str::slug($sentence,'-'),
            'content' => fake()->paragraph(3,true),
            'user_id' => User::factory(),
            'category_id' => Category::factory(),
        ];
    }
}
