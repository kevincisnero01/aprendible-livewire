<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\Storage;
use Livewire\Component;

class ArticleDeleteModal extends Component
{
    protected $listeners = ['confirmArticleDeletion'];

    public $article;

    public $showDeleteModal = false;

    public function confirmArticleDeletion($article)
    {   
        if($this->article->id === $article['id'])
        {
            $this->showDeleteModal = true;
        }
    }

    public function delete()
    {   
        if($this->article->image){
            Storage::disk('public')->delete($this->article->image);
        }
        
        $this->article->delete();
        session()->flash('flash.bannerStyle','danger');
        session()->flash('flash.banner', __('Deleted Article '));

        $this->redirectRoute('articles.index');
    }

    public function render()
    {
        return view('livewire.article-delete-modal');
    }
}
