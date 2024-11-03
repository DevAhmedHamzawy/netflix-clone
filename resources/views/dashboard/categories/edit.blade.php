@extends('layouts.dashboard.app')

@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard.welcome') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('dashboard.categories.index') }}">Categories</a></li>
            <li class="breadcrumb-item" active>Edit</li>
        </ol>
    </nav>

    <div class="tile mb-4">
        <form method="post" action="{{ route('dashboard.categories.update', $category->id) }}">
            @csrf
            @method('PuT')

            @include('dashboard.partials._errors')

            <div class="form-group">
                <label>Name</label>
                <input type="text" name="name" class="form-control" value="{{ $category->name }}">
            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-primary">
                    <div class="fa fa-edit"></div> Edit
                </button>
            </div>
        </form>
    </div>
@endsection
