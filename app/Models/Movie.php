<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Movie extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $appends = ['poster_path', 'image_path', 'is_favorite'];

    public function getPosterPathAttribute()
    {
        return Storage::url('image/' . $this->poster);
    }

    public function getImagePathAttribute()
    {
        return Storage::url('image/' . $this->image);
    }

    public function getIsFavoriteAttribute()
    {
        if(auth()->user()){
            return (bool)$this->users()->where('user_id', auth()->user()->id)->count();
        }

        return false;
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'movie_category');
    }

    public function scopeWhenSearch($query, $search)
    {
        return $query->when($search, function($q) use($search) {
            return $q->where('name', 'like',  "%$search%")
                ->orWhere('description' , 'like', "%$search%")
                ->orWhere('year' , 'like', "%$search%")
                ->orWhere('rating' , 'like', "%$search%");
        });
    }

    public function scopeWhenCategory($query, $category)
    {
        return $query->when($category, function($q) use ($category){
            return $q->whereHas('categories', function ($qu) use ($category) {
                return $qu->whereIn('category_id' , (array)$category)
                        ->orWhereIn('name' , (array)$category);
            });
        });
    }

    public function scopeWhenFavorite($query, $favorite)
    {
        return $query->when($favorite, function($q) {

            return $q->whereHas('users', function($qu){
                return $qu->where('user_id', auth()->user()->id);
            });

        });
    }


    public function users()
    {
        return $this->belongsToMany(User::class, 'user_movie');
    }
}
