@extends('valiant::layouts.guest')

@section('title', 'Reset Password')

@section('child-content')
    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <div class="input-group mb-3">
            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" placeholder="Email" value="{{ old('email') }}">
            <div class="input-group-append"><div class="input-group-text rounded-right"><span class="fa fa-fw fa-envelope"></span></div></div>
            @error('email')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
        </div>

        <button type="submit" class="btn btn-block btn-primary">Send Password Reset Link</button>
    </form>
@endsection
