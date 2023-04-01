<?php

namespace App\Http\Livewire;

use App\Models\Article;
use Livewire\Component;

class Articles extends Component
{
    public $search = '';
    public function render()
    {
        $articles = Article::where('title','like','%'.$this->search.'%')->latest()->get();
        return view('livewire.articles', [ 'articles' => $articles ]);
    }
}
