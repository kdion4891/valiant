<input type="hidden" name="{{ $field->name }}">

<div class="p-label">
    @foreach($field->input_options as $value => $label)
        <div class="form-check">
            <input
                type="checkbox"
                name="{{ $field->name }}[]"
                id="{{ $field->name . '.' . $loop->index }}"
                class="form-check-input @error($field->name) is-invalid @enderror"
                value="{{ $value }}"
                {{ is_array(old($field->name, $model->{$field->name})) && in_array($value, old($field->name, $model->{$field->name})) ? 'checked' : '' }}
            >

            <label for="{{ $field->name . '.' . $loop->index }}" class="form-check-label">
                {{ $label }}
            </label>
        </div>
    @endforeach

    @error($field->name)
        <span class="invalid-feedback d-block" role="alert"><strong>{{ $message }}</strong></span>
    @enderror
</div>
