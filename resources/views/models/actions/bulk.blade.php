@if($actions = $model->bulkActions())
    <div class="dropdown d-inline-block">
        <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">
            <i class="fa fa-check-square"></i>
        </button>
        <div class="dropdown-menu dropdown-menu-right">
            @foreach($actions as $action)
                @include($action->view)
            @endforeach
        </div>
    </div>
@endif
