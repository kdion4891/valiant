<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title') | {{ config('app.name') }}</title>

    <link rel="stylesheet" href="{{ asset('valiant/css/fontawesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('valiant/css/adminlte.min.css') }}">
    <link rel="stylesheet" href="{{ asset('valiant/css/datatables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('valiant/css/valiant.css') }}">
    <link rel="stylesheet" href="{{ asset('valiant/css/custom.css') }}">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700">
    <link rel="icon" href="{{ asset('valiant/img/favicon.png') }}">
</head>
<body class="hold-transition @yield('body-class')">
    @yield('parent-content')

    <script src="{{ asset('valiant/js/jquery.min.js') }}"></script>
    <script src="{{ asset('valiant/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('valiant/js/adminlte.min.js') }}"></script>
    <script src="{{ asset('valiant/js/datatables.min.js') }}"></script>
    <script src="{{ asset('valiant/js/valiant.js') }}"></script>
    <script src="{{ asset('valiant/js/custom.js') }}"></script>

    @if(session('status'))
        <script>$(document).Toasts('create', {class: 'bg-success', title: 'Success', body: '{{ session('status') }}', autohide: true, delay: 3000});</script>
    @elseif($errors->any())
        <script>$(document).Toasts('create', {class: 'bg-danger', title: 'Error', body: 'The given data was invalid.', autohide: true, delay: 3000});</script>
    @endif

    @stack('scripts')
</body>
</html>
