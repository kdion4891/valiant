@extends('valiant::layouts.auth')

@section('title', Str::plural($model->view_title))

@section('child-header')
    <div class="row">
        <div class="col-sm">
            <h1 class="mb-2 text-dark">@yield('title')</h1>
        </div>
        <div class="col-sm-auto">
            @include('valiant::models.actions.index')
            @include('valiant::models.actions.bulk')
        </div>
    </div>
@endsection

@section('child-content')
    <div class="card">
        <div class="card-body">
            {!! $html->table() !!}
        </div>
    </div>
@endsection

@push('scripts')
    {!! $html->scripts() !!}
@endpush
