<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Article extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function getImageUrlAttribute(): string
    {
        return $this->image 
            ? Storage::disk('public')->url($this->image) 
            : "https://via.placeholder.com/640x480.png/6875F5/FFFFFFF?text=No Image"
            ;
    }
    
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
