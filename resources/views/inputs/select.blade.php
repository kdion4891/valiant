<select
    name="{{ $field->name }}"
    id="{{ $field->name }}"
    class="custom-select @error($field->name) is-invalid @enderror"
>
    <option value=""></option>
    @foreach($field->input_options as $value => $label)
        <option value="{{ $value }}" {{ old($field->name, $model->{$field->name}) == $value ? 'selected' : '' }}>
            {{ $label }}
        </option>
    @endforeach
</select>

@error($field->name)
    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
@enderror
