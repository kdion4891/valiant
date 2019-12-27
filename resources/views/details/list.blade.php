<div class="card card-primary card-outline card-outline-tabs">
    @include('valiant::models.actions.detail')

    <div class="list-group list-group-flush">
        @foreach($model->fields() as $field)
            @if($field->detail)
                <div class="list-group-item">
                    <div class="row">
                        <div class="col-sm-2">
                            <b>{{ $field->label }}</b>
                        </div>
                        <div class="col-sm-8">
                            @if($field->detail_view_custom || $field->detail_view)
                                @include($field->detail_view_custom ? $field->detail_view_custom : $field->detail_view, $field->detail_view_custom_data)
                            @elseif($field->detail_alias)
                                {{ $model->{$field->detail_alias[0]}->{$field->detail_alias[1]} }}
                            @elseif(is_array($model->{$field->name}))
                                <pre class="p-0 mb-0">{{ json_encode($model->{$field->name}, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) }}</pre>
                            @else
                                {{ $model->{$field->name} }}
                            @endif
                        </div>
                    </div>
                </div>
            @endif
        @endforeach
    </div>
</div>
