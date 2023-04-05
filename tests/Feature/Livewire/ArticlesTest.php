<?php

namespace Tests\Feature\Livewire;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ArticlesTest extends TestCase
{
    use RefreshDatabase;
    
    public function test_articles_component_renders_properly(): void
    {
        $this->get(route('articles.index'))
            ->assertSeeLivewire('articles');
    }
}
