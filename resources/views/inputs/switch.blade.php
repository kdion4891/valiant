<input type="hidden" name="{{ $field->name }}" value="0">

<div class="p-label">
    <div class="custom-control custom-switch">
        <input
            type="checkbox"
            name="{{ $field->name }}"
            id="{{ $field->name }}"
            class="custom-control-input @error($field->name) is-invalid @enderror"
            value="1"
            {{ old($field->name, $model->{$field->name}) ? 'checked' : '' }}
        >

        <label for="{{ $field->name }}" class="custom-control-label"></label>
    </div>

    @error($field->name)
        <span class="invalid-feedback d-block" role="alert"><strong>{{ $message }}</strong></span>
    @enderror
</div>
