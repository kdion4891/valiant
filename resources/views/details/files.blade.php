@if($model->{$field->name})
    @foreach($model->{$field->name} as $key => $file)
        <div class="text-nowrap">
            <a href="{{ asset($file['file']) }}" target="_blank">
                <i class="fa {{ file_icon($file['mime_type']) }} mr-1"></i> {{ $file['name'] }}
            </a>
        </div>
    @endforeach
@endif
