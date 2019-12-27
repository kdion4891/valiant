@extends('valiant::layouts.app')

@section('body-class', 'sidebar-mini')
@section('parent-content')
    <div class="wrapper">
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
                </li>
            </ul>

            <ul class="navbar-nav ml-auto">
                @include('valiant::layouts.navs.header')
            </ul>
        </nav>

        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <a href="{{ url('/home') }}" class="brand-link">
                <img src="{{ asset('valiant/img/logo.png') }}" alt="AdminLTE Logo" class="brand-image">
                <span class="brand-text font-weight-light">{{ config('app.name') }}</span>
            </a>

            <div class="sidebar">
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                        @include('valiant::layouts.navs.sidebar')
                    </ul>
                </nav>
            </div>
        </aside>

        <div class="content-wrapper">
            <div class="content-header">
                <div class="container-fluid">
                    @yield('child-header')
                </div>
            </div>

            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col">
                            @yield('child-content')
                        </div>
                    </div>
                </div>
            </section>
        </div>

        <footer class="main-footer">
            <strong>Copyright &copy; {{ date('Y') }} <a href="{{ url('/') }}">{{ config('app.name') }}</a>.</strong> All rights reserved.
        </footer>
    </div>
@endsection
