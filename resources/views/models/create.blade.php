@extends('valiant::layouts.auth')

@section('title', 'Create ' . $model->view_title)

@section('child-header')
    <h1 class="mb-2 text-dark">@yield('title')</h1>
@endsection

@section('child-content')
    <form method="POST" action="{{ url($model->getTable() . '/create') }}" enctype="multipart/form-data">
        @csrf
        <div class="card">
            <div class="list-group list-group-flush">
                @include('valiant::inputs.list', ['action' => 'create'])
            </div>
            <div class="card-footer text-center bg-light rounded-bottom">
                <button type="submit" name="_submit" value="save" class="btn btn-primary">Save</button>
                <button type="submit" name="_submit" value="back" class="btn btn-primary">Save &amp; Go Back</button>
            </div>
        </div>
    </form>
@endsection
