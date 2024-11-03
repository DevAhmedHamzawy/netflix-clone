<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Jobs\StreamMovie;
use App\Models\Category;
use App\Models\Movie;
use Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MovieController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:movies-read')->only(['index']);
        $this->middleware('permission:movies-create')->only(['create','store']);
        $this->middleware('permission:movies-update')->only(['edit', 'update']);
        $this->middleware('permission:movies-delete')->only(['destroy']);

    }

    public function index()
    {
        $categories = Category::all();
        $movies = Movie::whenSearch(request()->search)->whenCategory(request()->category)->with('categories')->paginate(5);
        return view('dashboard.movies.index', compact('categories','movies'));
    }

    public function create()
    {
        $categories = Category::all();
        $movie = Movie::create([]);
        return view('dashboard.movies.create', compact('movie','categories'));
    }

    public function store(Request $request)
    {
        $movie = Movie::findOrFail($request->movie_id);
        $movie->update([
            'name' => $request->name,
            'path' => $request->file('movie')->store('movies'),
        ]);

        // i need to run a job to encode the movie in the background
        $this->dispatch(new StreamMovie($movie));

        return $movie;
    }

    public function show(Movie $movie)
    {
        return $movie;
    }

    public function edit(Movie $movie)
    {
        $categories = Category::all();
        return view('dashboard.movies.edit', compact('movie','categories'));
    }

    public function update(Request $request, Movie $movie)
    {
        if($request->type == 'publish'){
            $request->validate([
                'name' => 'required|unique:movies,name,' . $movie->id,
                'description' => 'required',
                'poster' => 'required|image',
                'image' => 'required|image',
                'categories' => 'required|array',
                'year' => 'required',
                'rating' => 'required'
            ]);

        }else{
            $request->validate([
                'name' => 'required|unique:movies,name,' . $movie->id,
                'description' => 'required',
                'poster' => 'sometimes|nullable|image',
                'image' => 'sometimes|nullable|image',
                'categories' => 'required|array',
                'year' => 'required',
                'rating' => 'required'
            ]);
        }

        $request_data = $request->except(['poster', 'image', 'categories', 'type']);

        if($request->poster){

            $this->remove_previous('poster' , $movie);

            $poster = Image::make($request->poster)->resize(255,378)->encode('jpg');

            Storage::disk('local')->put('public/image/' . $request->poster->hashName(), (string)$poster, 'public');

            $request_data['poster'] = $request->poster->hashName();
        }

        if($request->image){

            $this->remove_previous('image' , $movie);

            $image = Image::make($request->image)->encode('jpg', 50);

            Storage::disk('local')->put('public/image/' . $request->image->hashName(), (string)$image, 'public');

            $request_data['image'] = $request->image->hashName();
        }


        $movie->update($request_data);
        $movie->categories()->sync($request->categories);


        session()->flash('success', 'Data Updated Successfully');
        return redirect()->route('dashboard.movies.index');

    }

    public function destroy(Movie $movie)
    {
        Storage::disk('local')->delete('public/image/' . $movie->poster);

        Storage::disk('local')->delete('public/image/' . $movie->image);

        Storage::disk('local')->delete($movie->path);

        Storage::disk('local')->deleteDirectory('public/movies/' . $movie->id);

        $movie->delete();

        session()->flash('success', 'Data Deleted Successfully');

        return redirect()->route('dashboard.movies.index');

    }

    private function remove_previous($image_type, $movie)
    {
        if($image_type == 'poster'){
            if($movie->poster != null) Storage::disk('local')->delete('public/image/' . $movie->poster);
        }else{
            if($movie->image != null) Storage::disk('local')->delete('public/image/' . $movie->image);
        }

    }
}
