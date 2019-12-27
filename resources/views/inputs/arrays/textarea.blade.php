<textarea
    type="{{ $array_field->input_type }}"
    name="{{ $field->name }}[{{ $id }}][{{ $array_field->name }}]"
    class="form-control form-control-sm @error($field->name . '.' . $id . '.' . $array_field->name) is-invalid @enderror"
    placeholder="{{ $array_field->label }}"
    rows="{{ $field->input_rows }}"
>{{ old($field->name . '.' . $id . '.' . $array_field->name, $value[$array_field->name] ?? '') }}</textarea>

@error($field->name . '.' . $id . '.' . $array_field->name)
    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
@enderror
