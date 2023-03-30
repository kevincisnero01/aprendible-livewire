<?php

namespace App\Http\Livewire;

use App\Models\Article;
use Livewire\Component;

class Articles extends Component
{
    public function render()
    {
        $articles = Article::all();
        return view('livewire.articles', [ 'articles' => $articles ]);
    }
}
