<select
    name="{{ $field->name }}[{{ $id }}][{{ $array_field->name }}]"
    class="custom-select custom-select-sm @error($field->name . '.' . $id . '.' . $array_field->name) is-invalid @enderror"
>
    <option value="" disabled {{ !old($field->name . '.' . $id . '.' . $array_field->name, $value[$array_field->name] ?? '') ? 'selected' : '' }}>
        {{ $array_field->label }}
    </option>
    @foreach($array_field->input_options as $v => $l)
        <option value="{{ $v }}" {{ old($field->name . '.' . $id . '.' . $array_field->name, $value[$array_field->name] ?? '') == $v ? 'selected' : '' }}>
            {{ $l }}
        </option>
    @endforeach
</select>

@error($field->name . '.' . $id . '.' . $array_field->name)
<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
@enderror

