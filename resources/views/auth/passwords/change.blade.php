@extends('valiant::layouts.auth')

@section('title', 'Change Password')

@section('child-header')
    <h1 class="mb-2 text-dark">@yield('title')</h1>
@endsection

@section('child-content')
    <form method="POST" action="{{ url('profile/password') }}" enctype="multipart/form-data">
        @csrf
        <div class="card">
            <div class="list-group list-group-flush">
                @include('valiant::inputs.list', ['action' => 'profile_password'])
            </div>
            <div class="card-footer text-center bg-light rounded-bottom">
                <button type="submit" class="btn btn-primary">Save Password</button>
            </div>
        </div>
    </form>
@endsection
