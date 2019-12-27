@extends('valiant::layouts.auth')

@section('title', $model->view_title . ' Details')

@section('child-header')
    <div class="row">
        <div class="col-sm">
            <h1 class="mb-2 text-dark">@yield('title')</h1>
        </div>
        <div class="col-sm-auto">
            @include('valiant::models.actions.single')
        </div>
    </div>
@endsection

@section('child-content')
    @include('valiant::details.list')
@endsection
