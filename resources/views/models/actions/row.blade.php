@if($actions = $model->rowActions())
    <div class="text-right text-nowrap">
        @foreach($actions as $action)
            @include($action->view)
        @endforeach
    </div>
@endif
