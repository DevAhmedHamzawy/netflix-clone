@extends('layouts.dashboard.app')

@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard.welcome') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('dashboard.roles.index') }}">Roles</a></li>
            <li class="breadcrumb-item" active>Edit</li>
        </ol>
    </nav>

    <div class="tile mb-4">
        <form method="post" action="{{ route('dashboard.roles.update', $role->id) }}">
            @csrf
            @method('PuT')

            @include('dashboard.partials._errors')

            <div class="form-group">
                <label>Name</label>
                <input type="text" name="name" class="form-control" value="{{ $role->name }}">
            </div>

            <div class="form-group">
                <h4>Permissions</h4>
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Model</th>
                            <th>Permissions</th>
                        </tr>
                    </thead>

                    <tbody>
                        @php
                            $models = ['categories', 'movies', 'users', 'settings'];
                        @endphp

                        @foreach ($models as $index => $model)
                            <tr>
                                <td style="width: 5%">{{ $index + 1 }}</td>
                                <td style="width: 15%">{{ $model }}</td>
                                <td>
                                    @php
                                        $permission_maps = ['create', 'read', 'update', 'delete'];
                                    @endphp
                                    <select name="permissions[]" class="form-control select2" multiple>
                                        @foreach ($permission_maps as $permission_map)
                                            <option
                                                {{ $role->hasPermission($model . '-' . $permission_map) ? 'selected' : '' }}
                                                value="{{ $model . '-' . $permission_map }}">{{ $permission_map }}
                                            </option>
                                        @endforeach
                                    </select>
                                </td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>


            <div class="form-group">
                <button type="submit" class="btn btn-primary">
                    <div class="fa fa-edit"></div> Edit
                </button>
            </div>
        </form>
    </div>
@endsection
