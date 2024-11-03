@extends('layouts.dashboard.app')

@section('content')
    <h2>Roles</h2>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard.welcome') }}">Dashboard</a></li>
            <li class="breadcrumb-item" active>Roles</li>
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
                            @if (auth()->user()->hasPermission('roles-create'))
                                <a href="{{ route('dashboard.roles.create') }}" class="btn btn-primary"><i
                                        class="fa fa-plus"></i> Add</a>
                            @else
                                <a href="#" disabled class="btn btn-primary"><i class="fa fa-plus"></i> Add</a>
                            @endif
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            @if ($roles->count() > 0)
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Name</th>
                                            <th>Permissions</th>
                                            <th>Users Count</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @foreach ($roles as $index => $role)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ $role->name }}</td>
                                                <td>
                                                    @foreach ($role->permissions as $permission)
                                                        <h5 style="display: inline-block"><span
                                                                class="badge badge-primary">{{ $permission->name }}</span>
                                                        </h5>
                                                    @endforeach
                                                </td>
                                                <td>{{ $role->users_count }}</td>
                                                @if (auth()->user()->hasPermission('roles-update'))
                                                    <td><a href="{{ route('dashboard.roles.edit', $role->id) }}"
                                                            class="btn btn-warning btn-small"><i class="fa fa-edit"></i>
                                                            Edit</a>
                                                @endif
                                                @if (auth()->user()->hasPermission('roles-delete'))
                                                    <form method="post"
                                                        action="{{ route('dashboard.roles.destroy', $role->id) }}">
                                                        @csrf
                                                        @method('delete')

                                                        <button type="submit" class="btn btn-danger btn-small delete">
                                                            <div class="fa fa-trash"></div> Delete
                                                        </button>

                                                    </form>
                                                @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>

                                {{ $roles->appends(request()->query())->links() }}
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
