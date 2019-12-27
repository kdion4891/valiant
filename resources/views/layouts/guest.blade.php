@extends('valiant::layouts.app')

@section('body-class', 'login-page')
@section('parent-content')
    <div class="login-box">
        <div class="login-logo">
            <a href="{{ url('/') }}"><b>{{ config('app.name') }}</b></a>
        </div>

        <div class="card">
            <div class="card-body login-card-body">
                @yield('child-content')
            </div>
        </div>
    </div>
@endsection
