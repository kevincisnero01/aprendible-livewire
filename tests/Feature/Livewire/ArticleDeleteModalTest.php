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

class ArticleDeleteModalTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_delete_article():  void
    {
        $user = User::factory()->create();

        Storage::fake();

        $imagePath = UploadedFile::fake()
            ->image('image-test.png')
            ->store('/','public')
        ;

        $article = Article::factory()->create([
            'image' => $imagePath,
            'category_id' => Category::factory()->create()->id
        ]);

        Livewire::actingAs($user)->test('article-delete-modal',['article' => $article])
            ->call('delete')
            ->assertSessionHas('flash.bannerStyle','danger')
            ->assertSessionHas('flash.banner')
            ->assertRedirect(route('articles.index'))
        ;

        Storage::disk('public')->assertMissing($imagePath);

        $this->assertDatabaseCount('articles', 0);
    }
}
