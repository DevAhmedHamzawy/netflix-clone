@extends('layouts.dashboard.app')

@section('content')
    <h2>Categories</h2>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard.welcome') }}">Dashboard</a></li>
            <li class="breadcrumb-item" active>Categories</li>
        </ol>
    </nav>

    <div class="tile mb-4">
        <div class="row">
            <div class="col-12">
                <form action="">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <input type="text" name="search" class="form-control" autofocus
                                    value="{{ request()->search }}" placeholder="search">
                            </div>
                        </div>

                        <div class="col-md-4">
                            <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i>Search</button>
                            @if (auth()->user()->hasPermission('categories-create'))
                                <a href="{{ route('dashboard.categories.create') }}" class="btn btn-primary"><i
                                        class="fa fa-plus"></i> Add</a>
                            @else
                                <a href="#" disabled class="btn btn-primary"><i class="fa fa-plus"></i> Add</a>
                            @endif

                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            @if ($categories->count() > 0)
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Name</th>
                                            <th>Movies Count</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @foreach ($categories as $index => $category)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ $category->name }}</td>
                                                <td>{{ $category->movies_count }}</td>
                                                @if (auth()->user()->hasPermission('categories-update'))
                                                    <td><a href="{{ route('dashboard.categories.edit', $category->id) }}"
                                                            class="btn btn-warning btn-small"><i class="fa fa-edit"></i>
                                                            Edit</a>
                                                    @else
                                                    <td><a href="#" disabled class="btn btn-warning btn-small"><i
                                                                class="fa fa-edit"></i>
                                                            Edit</a>
                                                @endif
                                                @if (auth()->user()->hasPermission('categories-delete'))
                                                    <form method="post"
                                                        action="{{ route('dashboard.categories.destroy', $category->id) }}">
                                                        @csrf
                                                        @method('delete')

                                                        <button type="submit" class="btn btn-danger btn-small delete">
                                                            <div class="fa fa-trash"></div> Delete
                                                        </button>

                                                    </form>
                                                @else
                                                    <a href="#" disabled class="btn btn-danger"><i
                                                            class="fa fa-trash">Delete</i></a>
                                                @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>

                                {{ $categories->appends(request()->query())->links() }}
                            @else
                                <h3>Sorry no records found</h3>
                            @endif

                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
@endsection
