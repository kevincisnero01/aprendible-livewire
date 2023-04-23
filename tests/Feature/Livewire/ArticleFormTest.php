<?php

namespace Tests\Feature\Livewire;

use App\Models\Article;
use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;
use Livewire\Livewire;

class ArticleFormTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_cannot_create_or_update_article(): void
    {

        $this->get(route('articles.create'))
            ->assertRedirect('login');

        $article = Article::factory()->create();
        
        $this->get(route('articles.edit', $article))
            ->assertRedirect('login');

    }

    public function test_article_form_render_properly(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get(route('articles.create'))
            ->assertSeeLivewire('article-form')
            ->assertDontSeeText(__('Delete'))
            ;

        $article = Article::factory()->create();

        $this->actingAs($user)
            ->get(route('articles.edit',['article' => $article]))
            ->assertSeeLivewire('article-form')
            ->assertSeeText(__('Delete'));
            ;

    }

    public function test_blade_template_is_wired_property(): void
    {
        Livewire::test('article-form')
            ->assertSeeHtml('wire:submit.prevent="save"')
            ->assertSeeHtml('wire:model="article.title')
            ->assertSeeHtml('wire:model="article.slug')
        ;

    }

    public function test_can_create_new_articles(): void
    {
        Storage::fake('public');

        $image = UploadedFile::fake()->image('post-image.png');

        $user = User::factory()->create();

        $category = Category::factory()->create();

        Livewire::actingAs($user)->test('article-form')
            ->set('image',$image)
            ->set('article.title','Articulo Nuevo')
            ->set('article.slug','articulo-nuevo')
            ->set('article.content','Contenido de Articulo')
            ->set('article.category_id', $category->id)
            ->call('save')
            ->assertSessionHas('flash.banner')
            ->assertRedirect(route('articles.index'))
        ;

        $this->assertDatabaseHas('articles', [
            'image' => $imagePath = Storage::disk('public')->files()[0],
            'title' => 'Articulo Nuevo',
            'slug' => 'articulo-nuevo',
            'content' => 'Contenido de Articulo',
            'user_id' => $user->id,
            'category_id' => $category->id
        ]);

        Storage::disk('public')->assertExists($imagePath);
    }

    public function test_can_updade_articles(): void
    {
        $user = User::factory()->create();

        $article = Article::factory()->create([
            'image' => '/path/to/image',
            'category_id' => Category::factory()->create()->id
        ]);

        Livewire::actingAs($user)->test('article-form',['article' => $article])
            ->assertSet('article.title', $article->title)
            ->assertSet('article.slug', $article->slug)
            ->assertSet('article.content', $article->content)
            ->assertSet('article.category_id', $article->category->id)
            ->set('article.title', 'Articulo Nuevo')
            ->set('article.slug', 'slug-nuevo')
            ->call('save')
            ->dump()
            ->assertSessionHas('status')
            ->assertRedirect(route('articles.index'))
        ;

        $this->assertDatabaseCount('articles', 1);

        $this->assertDatabaseHas('articles',[
            'title' => 'Articulo Nuevo',
            'slug' => 'slug-nuevo',
            'user_id' => $user->id
        ]);
    }

    public function test_can_updade_articles_image(): void
    {   
        Storage::fake('public');

        $oldImage = UploadedFile::fake()->image('old-image.png');
        $oldImagePath = $oldImage->store('/','public');
        $newImage = UploadedFile::fake()->image('new-image.png');

        $article = Article::factory()->create([
            'image' => $oldImagePath
        ]);

        $user = User::factory()->create();

        Livewire::actingAs($user)->test('article-form',['article' => $article])
            ->set('image', $newImage)
            ->call('save')
            ->assertSessionHas('status')
            ->assertRedirect(route('articles.index'))
        ;

        Storage::disk('public')
            ->assertExists($article->fresh()->image)
            ->assertMissing($oldImage);
    }

    public function test_image_is_required(): void
    {
        Livewire::test('article-form')
            ->set('image','')
            ->set('article.title','Titulo de Articulo')
            ->set('article.content','Contenido de Articulo')
            ->call('save')
            ->assertHasErrors('image')
            ->assertSeeHtml(__('validation.required',['attribute' => 'image']))
        ;
    }

    public function test_field_must_be_of_type_image(): void
    {
        Livewire::test('article-form')
            ->set('image','string-not-allowed')
            ->call('save')
            ->assertHasErrors(['image' => 'image'])
            ->assertSeeHtml(__('validation.image',['attribute' => 'image']))
        ;
    }

    public function test_image_must_2mb_max(): void
    {
        Storage::fake('public');

        $image = UploadedFile::fake()->image('post-image.png')->size(3000);

        Livewire::test('article-form')
            ->set('image', $image)
            ->call('save')
            ->assertHasErrors(['image' => 'max'])
            ->assertSeeHtml(__('validation.max.file',[
                'attribute' => 'image',
                'max' => '2024',
            ]));
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

    public function test_slug_is_required(): void
    {
        Livewire::test('article-form')
            ->set('article.title','Titulo de Articulo')
            ->set('article.slug','')
            ->set('article.content','Contenido de Articulo')
            ->call('save')
            ->assertHasErrors('article.slug')
            ->assertSeeHtml(__('validation.required',['attribute' => 'slug']))
        ;
    }

    public function test_category_is_required(): void
    {
        Livewire::test('article-form')
            ->set('article.title','Titulo de Articulo')
            ->set('article.slug','titulo-de-articulo')
            ->set('article.content','Contenido de Articulo')
            ->set('article.category_id', null)
            ->call('save')
            ->assertHasErrors('article.category_id')
            ->assertSeeHtml(__('validation.required',['attribute' => 'category id']))
        ;
    }

    public function test_category_must_exist_in_database(): void
    {
        Livewire::test('article-form')
            ->set('article.title','Titulo de Articulo')
            ->set('article.slug','titulo-de-articulo')
            ->set('article.content','Contenido de Articulo')
            ->set('article.category_id', 1)
            ->call('save')
            ->assertHasErrors(['article.category_id' => 'exists'])
            ->assertSeeHtml(__('validation.exists',['attribute' => 'category id']))
        ;
    }

    public function test_can_create_new_category(): void
    {
        Livewire::test('article-form')
        ->call('openCategoryForm')
        ->set('newCategory.name','Livewire')
        ->assertSet('newCategory.slug','livewire')
        ->call('saveNewCategory')
        ->assertSet('article.category_id', Category::first()->id)
        ->assertSet('showCategoryModal', false)
        ;

        $this->assertDatabaseCount('categories',1);
    }

    public function test_new_category_name_is_required(): void
    {
        Livewire::test('article-form')
            ->call('openCategoryForm')
            ->set('newCategory.slug','livewire')
            ->call('saveNewCategory')
            ->assertHasErrors(['newCategory.name' => 'required'])
            ->assertSeeHtml(__('validation.required',['attribute' => 'name']))
        ;
    }

    public function test_new_category_slug_is_required(): void
    {
        Livewire::test('article-form')
            ->call('openCategoryForm')
            ->set('newCategory.name','Livewire')
            ->set('newCategory.slug',null)
            ->call('saveNewCategory')
            ->assertHasErrors(['newCategory.slug' => 'required'])
            ->assertSeeHtml(__('validation.required', ['attribute' => 'slug']))
            ;
    }

    public function test_category_name_must_be_unique(): void
    {
        $category = Category::factory()->create();

        Livewire::test('article-form')
            ->call('openCategoryForm')
            ->set('newCategory.name', $category->name)
            ->set('newCategory.slug', 'laravel')
            ->call('saveNewCategory')
            ->assertHasErrors(['newCategory.name' => 'unique'])
            ->assertSeeHtml(__('validation.unique',['attribute' => 'name']))
        ;
    }

    public function test_category_slug_must_be_unique(): void
    {
        $category = Category::factory()->create();

        Livewire::test('article-form')
            ->call('openCategoryForm')
            ->set('newCategory.name', 'Laravel')
            ->set('newCategory.slug',  $category->slug)
            ->call('saveNewCategory')
            ->assertHasErrors(['newCategory.slug' => 'unique'])
            ->assertSeeHtml(__('validation.unique',['attribute' => 'slug']))
        ;
    }

    public function test_slug_must_be_unique(): void
    {
        $article = Article::factory()->create();

        Livewire::test('article-form')
            ->set('article.title','Titulo de Articulo')
            ->set('article.slug', $article->slug)
            ->set('article.content','Contenido de Articulo')
            ->call('save')
            ->assertHasErrors(['article.slug' => 'unique'])
            ->assertSeeHtml(__('validation.unique',['attribute' => 'slug']))
        ;
    }

    public function test_unique_rule_should_be_ignored_when_updating_the_same_slug(): void
    {
        $user = User::factory()->create();

        $article = Article::factory()->create();

        Livewire::actingAs($user)->test('article-form',['article' => $article])
            ->set('article.title','Titulo de Articulo')
            ->set('article.slug', $article->slug)
            ->set('article.content','Contenido de Articulo')
            ->call('save')
            ->assertHasNoErrors(['article.slug' => 'unique'])
        ;
    }

    public function test_slug_must_only_contain_letters_numbers_dashes(): void
    {

        Livewire::test('article-form')
            ->set('article.title','Titulo de Articulo')
            ->set('article.slug', 'titulo-de-articulo%$!(' )
            ->set('article.content','Contenido de Articulo')
            ->call('save')
            ->assertHasErrors(['article.slug' => 'alpha_dash'])
            ->assertSeeHtml(__('validation.alpha_dash',['attribute' => 'slug']))
        ;
    }

    public function test_slug_is_generated_automatically(): void
    {
        Livewire::test('article-form')
            ->set('article.title','Articulo Nuevo')
            ->assertSet('article.slug','articulo-nuevo')
        ;
    }

    public function test_title_must_be_4_characters_min(): void
    {
        Livewire::test('article-form')
            ->set('article.title','abc')
            ->set('article.content','Contenido de Articulo')
            ->call('save')
            ->assertHasErrors(['article.title' => 'min'])
            ->assertSeeHtml(__('validation.min.string',[
                'attribute' => 'title',
                'min' => 4
            ]))
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
