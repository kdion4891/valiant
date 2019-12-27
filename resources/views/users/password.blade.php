@extends('valiant::layouts.auth')

@section('title', 'Change ' . $model->view_title . ' Password')

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
    <form method="POST" action="{{ url($model->getTable() . '/password/' . $model->id) }}" enctype="multipart/form-data">
        @csrf
        <div class="card">
            <div class="list-group list-group-flush">
                @include('valiant::inputs.list', ['action' => 'password'])
            </div>
            <div class="card-footer text-center bg-light rounded-bottom">
                <button type="submit" name="_submit" value="save" class="btn btn-primary">Save</button>
                <button type="submit" name="_submit" value="back" class="btn btn-primary">Save &amp; Go Back</button>
            </div>
        </div>
    </form>
@endsection
