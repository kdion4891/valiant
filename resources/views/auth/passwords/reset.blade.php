@extends('valiant::layouts.guest')

@section('title', 'Reset Password')

@section('child-content')
    <form method="POST" action="{{ route('password.update') }}">
        @csrf

        <input type="hidden" name="token" value="{{ $token }}">

        <div class="input-group mb-3">
            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" placeholder="Email" value="{{ $email ?? old('email') }}">
            <div class="input-group-append"><div class="input-group-text rounded-right"><span class="fa fa-fw fa-envelope"></span></div></div>
            @error('email')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
        </div>

        <div class="input-group mb-3">
            <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="Password">
            <div class="input-group-append"><div class="input-group-text rounded-right"><span class="fa fa-fw fa-lock"></span></div></div>
            @error('password')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
        </div>

        <div class="input-group mb-3">
            <input type="password" name="password_confirmation" class="form-control" placeholder="Confirm Password">
            <div class="input-group-append"><div class="input-group-text rounded-right"><span class="fa fa-fw fa-lock"></span></div></div>
        </div>

        <button type="submit" class="btn btn-block btn-primary">Reset Password</button>
    </form>
@endsection
