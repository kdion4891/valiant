<div class="p-label">
    @foreach($field->input_options as $value => $label)
        <div class="form-check">
            <input
                type="radio"
                name="{{ $field->name }}"
                id="{{ $field->name . '.' . $loop->index }}"
                class="form-check-input @error($field->name) is-invalid @enderror"
                value="{{ $value }}"
                {{ old($field->name, $model->{$field->name}) == $value || $loop->first ? 'checked' : '' }}
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
