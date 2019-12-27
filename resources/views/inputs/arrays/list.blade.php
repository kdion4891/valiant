<input type="hidden" name="{{ $field->name }}">

<div class="list-group list-group-hover" data-fields="{{ $field->name }}">
    @if(old($field->name, $model->{$field->name}))
        @foreach(old($field->name, $model->{$field->name}) as $id => $value)
            @include('valiant::inputs.arrays.item')
        @endforeach
    @endif
</div>

<button
    type="button"
    data-ajax-post="{{ url($model->getTable() . '/add-field/' . $field->name) }}"
    data-ajax-token="{{ csrf_token() }}"
    class="btn btn-outline-primary"
>
    Add {{ Str::singular($field->label) }}
</button>

@error($field->name)
    <span class="invalid-feedback d-block" role="alert"><strong>{{ $message }}</strong></span>
@enderror
