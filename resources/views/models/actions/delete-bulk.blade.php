<form method="POST" action="{{ url($model->getTable() . '/delete-bulk') }}" data-ajax-form>
    @csrf
    <input type="hidden" name="ids" data-checkbox-ids>
    <button type="submit" class="dropdown-item" data-confirm="Are you sure?">
        Delete
    </button>
</form>
