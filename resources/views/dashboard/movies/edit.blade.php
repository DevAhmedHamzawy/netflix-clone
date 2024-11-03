@extends('layouts.dashboard.app')

@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard.welcome') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('dashboard.movies.index') }}">Movies</a></li>
            <li class="breadcrumb-item" active>Edit</li>
        </ol>
    </nav>

    <div class="tile mb-4">

        <form id="movie__properties" method="post"
            action="{{ route('dashboard.movies.update', ['movie' => $movie->id, 'type' => 'update']) }}"
            enctype="multipart/form-data">
            @csrf
            @method('PUT')

            @include('dashboard.partials._errors')

            <div class="form-group" style="display: {{ $errors->any() ? 'none' : 'block' }}">

                <label id="movie_upload-status">Uploading</label>
                <div class="progress">
                    <div class="progress-bar" id="movie__upload-progress" role="progressbar"></div>
                </div>
            </div>

            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" name="name" id="movie__name" value="{{ $movie->name }}" class="form-control">
            </div>

            <div class="form-group">
                <label for="description">Description</label>
                <input type="text" name="description" value="{{ $movie->description }}" class="form-control">
            </div>

            <div class="form-group">
                <label for="poster">Poster</label>
                <input type="file" name="poster" class="form-control">
                <img src="{{ $movie->poster_path }}" style="margin-top: 10px;width: 255px;height: 378px" alt=""
                    srcset="">
            </div>

            <div class="form-group">
                <label for="image">Image</label>
                <input type="file" name="image" class="form-control">
                <img src="{{ $movie->image_path }}" style="margin-top: 10px;width: 300px;height: 300px" alt="">
            </div>

            <div class="form-group">
                <label for="category">Category</label>
                <select name="categories[]" class="form-control select2" id="categories" multiple>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}"
                            {{ in_array($category->id, $movie->categories->pluck('id')->toArray()) ? 'selected' : '' }}>
                            {{ $category->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="year">Year</label>
                <input type="text" name="year" value="{{ old('year', $movie->year) }}" class="form-control">
            </div>

            <div class="form-group">
                <label for="rating">Rating</label>
                <input type="number" min="1" value="{{ old('rating', $movie->rating) }}" name="rating"
                    class="form-control">
            </div>



            <div class="form-group">
                <button type="submit" class="btn btn-primary">
                    <div class="fa fa-edit"></div> Edit
                </button>
            </div>
        </form>
    </div>
@endsection
