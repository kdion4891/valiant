<input type="hidden" name="{{ $field->name }}" value="0">

<div class="p-label">
    <div class="form-check">
        <input
            type="checkbox"
            name="{{ $field->name }}"
            id="{{ $field->name }}"
            class="form-check-input @error($field->name) is-invalid @enderror"
            value="1"
            {{ old($field->name, $model->{$field->name}) ? 'checked' : '' }}
        >

        <label for="{{ $field->name }}" class="form-check-label"></label>
    </div>

    @error($field->name)
        <span class="invalid-feedback d-block" role="alert"><strong>{{ $message }}</strong></span>
    @enderror
</div>
