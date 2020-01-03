<a
    href="{{ url($model->getTable() . '/edit/' . $model->id) }}"
    class="btn {{ Request::ajax() ? 'btn-sm' : '' }} btn{{ !Request::is($model->getTable() . '/edit/' . $model->id) ? '-outline' : '' }}-primary px-btn"
    title="Edit"
>
    <i class="fa fa-fw fa-edit"></i>
</a>
