<?php

namespace Tests\Feature\Livewire;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Livewire\Livewire;

class ArticleFormTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic test example.
     */
    public function test_can_create_new_articles(): void
    {
        Livewire::test('article-form')
            ->set('article.title','Articulo Nuevo')
            ->set('article.content','Contenido de Articulo')
            ->call('save')
            ->assertSessionHas('status')
            ->assertRedirect(route('articles.index'))
        ;

        $this->assertDatabaseHas('articles', [
            'title' => 'Articulo Nuevo',
            'content' => 'Contenido de Articulo'
        ]);
    }

    public function test_title_is_required(): void
    {
        Livewire::test('article-form')
            ->set('article.title','')
            ->set('article.content','Contenido de Articulo')
            ->call('save')
            ->assertHasErrors('article.title')
        ;
    }

    public function test_title_must_be_4_characters_min(): void
    {
        Livewire::test('article-form')
            ->set('article.title','abc')
            ->set('article.content','Contenido de Articulo')
            ->call('save')
            ->assertHasErrors(['article.title' => 'min'])
        ;
    }

    public function test_content_is_required(): void
    {
        Livewire::test('article-form')
            ->set('article.title','Articulo Nuevo')
            ->set('article.content','')
            ->call('save')
            ->assertHasErrors(['article.content' => 'required'])
        ;
    }

    public function test_real_time_validation_works_for_title(): void
    {
        Livewire::test('article-form')
            ->set('article.title', '')
            ->assertHasErrors(['article.title' => 'required'])
            ->set('article.title', 'abc')
            ->assertHasErrors(['article.title' => 'min'])
            ->set('article.title', 'Nuevo Articulo')
            ->assertHasNoErrors('article.title')
        ;
    }

    public function test_real_time_validation_works_for_content(): void
    {
        Livewire::test('article-form')
            ->set('article.content', '')
            ->assertHasErrors(['article.content' => 'required'])
            ->set('article.content', 'Contenido de Articulo')
            ->assertHasNoErrors('article.content')
        ;
    }
}
