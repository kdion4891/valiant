<a
    href="{{ url($model->getTable() . '/password/' . $model->id) }}"
    class="btn {{ Request::ajax() ? 'btn-sm' : '' }} btn{{ !Request::is($model->getTable() . '/password/' . $model->id) ? '-outline' : '' }}-primary px-btn"
    title="Password"
>
    <i class="fa fa-fw fa-lock"></i>
</a>
