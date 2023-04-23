<?php

use App\Http\Livewire\ArticleForm;
use App\Http\Livewire\ArticlesTable;
use App\Http\Livewire\ArticleShow;
use Illuminate\Support\Facades\Route;

Route::view('/','home')->name('home');

Route::get('/blog/{article}',ArticleShow::class)->name('articles.show');

Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])
    ->prefix('dashboard')->group(function(){

    Route::view('/', 'dashboard')->name('dashboard');

    Route::get('/blog', ArticlesTable::class)->name('articles.index');

    Route::get('/blog/create', ArticleForm::class)->name('articles.create');

    Route::get('/blog/{article:id}/edit', ArticleForm::class)->name('articles.edit');

});
