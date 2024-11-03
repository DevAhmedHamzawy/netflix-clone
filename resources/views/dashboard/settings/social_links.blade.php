@extends('layouts.dashboard.app')

@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard.welcome') }}">Dashboard</a></li>
            <li class="breadcrumb-item active">Settings</li>
        </ol>
    </nav>

    <div class="tile mb-4">
        <form method="post" action="{{ route('dashboard.settings.store') }}">
            @csrf

            @include('dashboard.partials._errors')

            @php
                $social_sites = ['facebook', 'google', 'youtube'];
            @endphp

            @foreach ($social_sites as $social_site)
                <div class="form-group">
                    <label class="text-capitalize">{{ $social_site }} link</label>
                    <input type="text" name="{{ $social_site }}_link" class="form-control"
                        value="{{ setting($social_site . '_link') }}">
                </div>
            @endforeach



            <div class="form-group">
                <button type="submit" class="btn btn-primary">
                    <div class="fa fa-plus"></div> Add
                </button>
            </div>
        </form>
    </div>
@endsection
