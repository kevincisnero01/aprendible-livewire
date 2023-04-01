<?php

namespace App\Http\Livewire;

use App\Models\Article;
use Livewire\Component;

class ArticleForm extends Component
{
    public $title;

    public $content;

    protected $rules = [
        'title' => ['required', 'min:4'],
        'content' => ['required']
    ];

    public function updated($propertyName){
        $this->validateOnly($propertyName);
    }
    
    public function save()
    {
        Article::create($this->validate());

        session()->flash('status','Registro Exitoso');

        $this->redirectRoute('articles.index');
    }

    public function render()
    {
        return view('livewire.article-form');
    }
}