@if($actions = $model->detailActions())
    <div class="card-header p-0 border-bottom-0">
        <ul class="nav nav-tabs" role="tablist">
            @foreach($actions as $action)
                @include($action->view)
            @endforeach
        </ul>
    </div>
@endif
