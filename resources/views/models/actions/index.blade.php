@if($actions = $model->indexActions())
    @foreach($actions as $action)
        @include($action->view)
    @endforeach
@endif
