<input
    type="{{ $field->input_type }}"
    name="{{ $field->name }}"
    id="{{ $field->name }}"
    class="form-control @error($field->name) is-invalid @enderror"
    value="{{ !in_array($field->name, $model->getHidden()) ? old($field->name, $model->{$field->name}) : '' }}"
>

@error($field->name)
    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
@enderror
