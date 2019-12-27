<input type="hidden" name="{{ $field->name }}[{{ $id }}][{{ $array_field->name }}]" value="0">

<div class="form-check">
    <input
        type="checkbox"
        name="{{ $field->name }}[{{ $id }}][{{ $array_field->name }}]"
        id="{{ $field->name . '.' . $id . '.' . $array_field->name }}"
        class="form-check-input @error($field->name . '.' . $id . '.' . $array_field->name) is-invalid @enderror"
        value="1"
        {{ old($field->name . '.' . $id . '.' . $array_field->name, $value[$array_field->name] ?? '') ? 'checked' : '' }}
    >

    <label for="{{ $field->name . '.' . $id . '.' . $array_field->name }}" class="form-check-label small">
        {{ $array_field->label }}
    </label>
</div>

@error($field->name . '.' . $id . '.' . $array_field->name)
    <span class="invalid-feedback d-block" role="alert"><strong>{{ $message }}</strong></span>
@enderror
