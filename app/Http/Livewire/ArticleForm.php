<?php

namespace App\Http\Livewire;

use App\Models\Article;
use Livewire\Component;

class ArticleForm extends Component
{
    public Article $article;

    protected $rules = [
        'article.title' => ['required', 'min:4'],
        'article.content' => ['required']
    ];

    public function updated($propertyName){
        $this->validateOnly($propertyName);
    }
    
    public function mount(Article $article){
        $this->article = $article;
    }

    public function save()
    {
        $this->validate();

        $this->article->save();

        session()->flash('status','Artículo Guardado');

        $this->redirectRoute('articles.index');
    }

    public function render()
    {
        return view('livewire.article-form');
    }
}