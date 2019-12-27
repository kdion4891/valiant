@extends('valiant::layouts.guest')

@section('title', 'Login')

@section('child-content')
    <form method="POST" action="{{ route('login') }}">
        @csrf

        <input type="hidden" name="timezone" value="{{ config('app.timezone') }}" data-user-timezone>

        <div class="input-group mb-3">
            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" placeholder="Email" value="{{ old('email') }}">
            <div class="input-group-append"><div class="input-group-text rounded-right"><span class="fa fa-fw fa-envelope"></span></div></div>
            @error('email')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
        </div>

        <div class="input-group mb-3">
            <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="Password">
            <div class="input-group-append"><div class="input-group-text rounded-right"><span class="fa fa-fw fa-lock"></span></div></div>
            @error('password')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
        </div>

        <div class="form-check mb-3">
            <input type="checkbox" name="remember" id="remember" class="form-check-input" {{ old('remember') ? 'checked' : '' }}>
            <label for="remember" class="form-check-label">Remember Me</label>
        </div>

        <button type="submit" class="btn btn-block btn-primary">Login</button>

        @if (Route::has('password.request'))
            <p class="text-center mt-3 mb-0">
                <a href="{{ route('password.request') }}">Forgot Your Password?</a>
            </p>
        @endif
    </form>
@endsection
