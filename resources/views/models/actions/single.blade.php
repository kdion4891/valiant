@if($actions = $model->singleActions())
    <div class="text-right text-nowrap">
        @foreach($actions as $action)
            @include($action->view)
        @endforeach
    </div>
@endif
