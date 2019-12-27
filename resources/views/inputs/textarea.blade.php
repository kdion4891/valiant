<textarea
    type="{{ $field->input_type }}"
    name="{{ $field->name }}"
    id="{{ $field->name }}"
    class="form-control @error($field->name) is-invalid @enderror"
    rows="{{ $field->input_rows }}"
>{{ old($field->name, $model->{$field->name}) }}</textarea>

@error($field->name)
    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
@enderror
