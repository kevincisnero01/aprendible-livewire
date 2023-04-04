<?php

namespace App\Http\Livewire;

use App\Models\Article;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Illuminate\Support\Str;

class ArticleForm extends Component
{
    public Article $article;

    protected function rules(){
        return [
            'article.title' => ['required', 'min:4'],
            'article.slug' => [
                'required',
                'alpha_dash',
                Rule::unique('articles','slug')->ignore($this->article)
            ],
            'article.content' => ['required']
        ];
    }

    public function updated($propertyName){
        $this->validateOnly($propertyName);
    }

    public function updatedArticleTitle($title)
    {
        $this->article->slug = Str::slug($title);
    }
    
    public function mount(Article $article){
        $this->article = $article;
    }

    public function save()
    {
        $this->validate();

        //auth()->user()
        Auth::user()->articles()->save($this->article);

        session()->flash('status','Artículo Guardado');

        $this->redirectRoute('articles.index');
    }

    public function render()
    {
        return view('livewire.article-form');
    }
}