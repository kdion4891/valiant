@if($model->{$field->name})
    <div class="list-group list-group-hover">
        @foreach($model->{$field->name} as $key => $file)
            <div class="list-group-item p-2 border-bottom-0" data-file="{{ $key }}">
                <div class="form-row align-items-center">
                    <div class="col">
                        <a href="{{ asset($file['file']) }}" target="_blank">
                            <i class="fa {{ file_icon($file['mime_type']) }} mr-1"></i> {{ $file['name'] }}
                        </a>
                    </div>
                    <div class="col-auto">
                        <button
                            type="button"
                            data-ajax-post="{{ url($model->getTable() . '/delete-file/' . $model->id . '/' . $field->name . '/' . $key) }}"
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
        @endforeach
    </div>
@endif
