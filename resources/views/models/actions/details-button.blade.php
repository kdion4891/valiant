<a
    href="{{ url($model->getTable() . '/details/' . $model->id) }}"
    class="btn {{ Request::ajax() ? 'btn-sm' : '' }} btn{{ !Request::is($model->getTable() . '/details*' . $model->id) ? '-outline' : '' }}-primary px-btn"
    title="Details"
>
    <i class="fa fa-fw fa-eye"></i>
</a>
