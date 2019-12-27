<div class="list-group-item p-2 border-bottom-0" data-field="{{ $id }}">
    <div class="form-row">
        @foreach($field->input_fields as $array_field)
            <div class="{{ $array_field->input_column_class }}">
                @include($array_field->input_view_custom ? $array_field->input_view_custom : $array_field->input_view, $array_field->input_view_custom_data)
            </div>
        @endforeach
        <div class="col-auto">
            <button
                type="button"
                data-ajax-post="{{ url($model->getTable() . '/delete-field/' . $id) }}"
                data-ajax-token="{{ csrf_token() }}"
                data-confirm="Are you sure?"
                class="btn btn-sm btn-outline-danger px-btn"
                title="Delete"
            >
                <i class="fa fa-fw fa-trash"></i>
            </button>
        </div>
    </div>
</div>
