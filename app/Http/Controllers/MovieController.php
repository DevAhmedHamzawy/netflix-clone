<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use Illuminate\Http\Request;

class MovieController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $movies = Movie::whenCategory(request()->category_name)->whenSearch(request()->search)->whenFavorite(request()->favorite)->paginate(20);

        if(request()->ajax()){
            $movies = Movie::whenSearch(request()->search)->get();
            return $movies;
        }

        return view('movies.index', compact('movies'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Movie  $movie
     * @return \Illuminate\Http\Response
     */
    public function show(Movie $movie)
    {
        $related_movies = Movie::where('id' , "!=" , $movie->id)
                                ->whereHas('categories', function($query) use($movie){
                                    return $query->whereIn('category_id', $movie->categories->pluck('id')->toArray());
                                })->get();

        return view('movies.show', compact('movie','related_movies'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Movie  $movie
     * @return \Illuminate\Http\Response
     */
    public function edit(Movie $movie)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Movie  $movie
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Movie $movie)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Movie  $movie
     * @return \Illuminate\Http\Response
     */
    public function destroy(Movie $movie)
    {
        //
    }

    public function increment_views(Movie $movie)
    {
        $movie->increment('views');
    }

    public function toggle_favorite(Movie $movie)
    {
        $movie->is_favorite ? $movie->users()->detach(auth()->user()->id) :  $movie->users()->attach(auth()->user()->id);

    }
}
