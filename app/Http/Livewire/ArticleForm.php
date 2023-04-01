<?php

namespace App\Http\Livewire;

use App\Models\Article;
use Livewire\Component;

class ArticleForm extends Component
{
    public $title;
    public $content;

    public function render()
    {
        return view('livewire.article-form');
    }

    public function save()
    {
        Article::create([
            'title' => $this->title,
            'content' => $this->content
        ]);

        session()->flash('status','Registro Exitoso');
        $this->redirectRoute('articles.index');
    }
}
