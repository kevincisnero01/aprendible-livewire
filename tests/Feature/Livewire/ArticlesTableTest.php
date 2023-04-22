<?php

namespace Tests\Feature\Livewire;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ArticlesTableTest extends TestCase
{
    use RefreshDatabase;

    public function test_articles_component_renders_properly(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get(route('articles.index'))
            ->assertSeeLivewire('articles-table');
    }
}
