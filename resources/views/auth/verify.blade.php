@extends('valiant::layouts.guest')

@section('title', 'Verify Your Email Address')

@section('child-content')
    <p class="login-box-msg">
        @if (session('resent'))
            <span class="text-success">A fresh verification link has been sent to your email address.</span>
        @else
            Before proceeding, please check your email for a verification link.
        @endif
    </p>

    <form method="POST" action="{{ route('verification.resend') }}">
        @csrf
        <button type="submit" class="btn btn-block btn-primary">Resend Verification Link</button>
    </form>
@endsection
