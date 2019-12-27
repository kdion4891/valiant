@extends('valiant::layouts.auth')

@section('title', 'Dashboard')

@section('child-header')
    <h1 class="mb-2 text-dark">@yield('title')</h1>
@endsection

@section('child-content')
    <div class="card">
        <div class="card-body">
            <p class="card-text">
                You are logged in!
            </p>
        </div>
    </div>
@endsection
