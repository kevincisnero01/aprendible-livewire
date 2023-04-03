<?php

namespace Tests\Feature\Livewire;

use App\Models\Article;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Livewire\Livewire;

class ArticleFormTest extends TestCase
{
    use RefreshDatabase;

    public function test_blade_template_is_wired_property(): void
    {
        Livewire::test('article-form')
            ->assertSeeHtml('wire:submit.prevent="save"')
            ->assertSeeHtml('wire:model="article.title"')
            ->assertSeeHtml('wire:model="article.content"')
        ;

    }

    public function test_article_form_render_properly(): void
    {
        $this->get(route('articles.create'))->assertSeeLivewire('article-form');

        $article = Article::factory()->create();

        $this->get(route('articles.edit',['article' => $article]))->assertSeeLivewire('article-form');

    }

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

    public function test_can_updade_articles(): void
    {
        $article = Article::factory()->create();

        Livewire::test('article-form',['article' => $article])
            ->assertSet('article.title', $article->title)
            ->assertSet('article.content', $article->content)
            ->set('article.title', 'Articulo Nuevo')
            ->call('save')
            ->assertSessionHas('status')
            ->assertRedirect(route('articles.index'))
        ;

        $this->assertDatabaseCount('articles', 1);

        $this->assertDatabaseHas('articles',[
            'title' => 'Articulo Nuevo'
        ]);
    }

    public function test_title_is_required(): void
    {
        Livewire::test('article-form')
            ->set('article.title','')
            ->set('article.content','Contenido de Articulo')
            ->call('save')
            ->assertHasErrors('article.title')
            ->assertSeeHtml(__('validation.required',['attribute' => 'title']))
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
