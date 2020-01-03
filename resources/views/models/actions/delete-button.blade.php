<form method="POST" action="{{ url($model->getTable() . '/delete/' . $model->id) }}" class="d-inline" data-ajax-form>
    @csrf
    <input type="hidden" name="request_ajax" value="{{ Request::ajax() }}">
    <button type="submit" class="btn {{ Request::ajax() ? 'btn-sm' : '' }} btn-outline-danger px-btn" title="Delete" data-confirm="Are you sure?">
        <i class="fa fa-fw fa-trash"></i>
    </button>
</form>
