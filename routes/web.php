<?php

use App\Http\Livewire\ArticleForm;
use App\Http\Livewire\Articles;
use App\Http\Livewire\ArticleShow;
use Illuminate\Support\Facades\Route;


Route::get('/', Articles::class)->name('articles.index');

Route::get('/blog/create', ArticleForm::class)
    ->name('articles.create')
    ->middleware('auth');

Route::get('/blog/{article}',ArticleShow::class)->name('articles.show');

Route::get('/blog/{article:id}/edit',ArticleForm::class)
    ->name('articles.edit')
    ->middleware('auth');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});
