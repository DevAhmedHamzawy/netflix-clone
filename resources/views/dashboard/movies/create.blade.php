@extends('layouts.dashboard.app')

@push('styles')
    <style>
        #movie__upload-wrapper {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 25vh;
            flex-direction: column;
            cursor: pointer;
            border: 1px solid black;

        }
    </style>
@endpush

@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard.welcome') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('dashboard.movies.index') }}">Movies</a></li>
            <li class="breadcrumb-item" active>Add</li>
        </ol>
    </nav>

    <div class="tile mb-4">

        <div id="movie__upload-wrapper" onclick="document.getElementById('movie__file-input').click()"
            style="display: {{ $errors->any() ? 'none' : 'flex' }}">
            <i class="fa fa-video-camera fa-2x"></i>
            <p>Click To Upload</p>
        </div>

        <input type="file" name="" data-movie-id="{{ $movie->id }}" data-url="../../dashboard/movies"
            id="movie__file-input" style="display:none;">

        <form id="movie__properties" method="post"
            action="{{ route('dashboard.movies.update', ['movie' => $movie->id, 'type' => 'publish']) }}"
            enctype="multipart/form-data" style="display: {{ $errors->any() ? 'block' : 'none' }}">
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
                <input type="text" name="name" id="movie__name" value="{{ old('name'), $movie->name }}"
                    class="form-control">
            </div>

            <div class="form-group">
                <label for="description">Description</label>
                <input type="text" name="description" value="{{ old('description'), $movie->description }}"
                    class="form-control">
            </div>

            <div class="form-group">
                <label for="poster">Poster</label>
                <input type="file" name="poster" class="form-control">
            </div>

            <div class="form-group">
                <label for="image">Image</label>
                <input type="file" name="image" class="form-control">
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
                <button type="submit" id="movie__submit-btn" style="display: {{ $errors->any() ? 'block' : 'none' }}"
                    class="btn btn-primary">
                    <div class="fa fa-plus"></div> Publish
                </button>
            </div>
        </form>
    </div>
@endsection
