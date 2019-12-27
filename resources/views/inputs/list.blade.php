@foreach($model->fieldInputs($action) as $field)
    <div class="list-group-item">
        <div class="row">
            <label for="{{ $field->name }}" class="col-sm-2 col-form-label">{{ $field->label }}</label>
            <div class="col-sm-8">
                @include($field->input_view_custom ? $field->input_view_custom : $field->input_view, $field->input_view_custom_data)
            </div>
        </div>
    </div>
@endforeach
