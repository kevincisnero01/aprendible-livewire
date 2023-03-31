<?php

namespace App\Http\Livewire;

use App\Models\Article;
use Livewire\Component;

class Articles extends Component
{
    public $search = '';
    public function render()
    {
        $articles = Article::where('name','like','%'.$this->search.'%')->get();
        return view('livewire.articles', [ 'articles' => $articles ]);
    }
}
