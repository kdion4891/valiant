@extends('valiant::layouts.guest')

@section('title', 'Confirm Password')

@section('child-content')
    <p class="login-box-msg">
        Please confirm your password before continuing.
    </p>

    <form method="POST" action="{{ route('password.confirm') }}">
        @csrf

        <div class="input-group mb-3">
            <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="Password">
            <div class="input-group-append"><div class="input-group-text rounded-right"><span class="fa fa-fw fa-lock"></span></div></div>
            @error('password')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
        </div>

        <button type="submit" class="btn btn-block btn-primary">Confirm Password</button>

        @if (Route::has('password.request'))
            <p class="text-center mt-3 mb-0">
                <a href="{{ route('password.request') }}">Forgot Your Password?</a>
            </p>
        @endif
    </form>
@endsection
