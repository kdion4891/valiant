@foreach($field->input_options as $value => $label)
    <div class="text-nowrap">
        <i class="fa fa-fw {{ is_array($model->{$field->name}) && in_array($value, $model->{$field->name}) ? 'fa-check text-success' : 'fa-times text-danger' }}"></i>
        {{ $label }}
    </div>
@endforeach
