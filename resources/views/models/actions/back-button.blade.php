<a
    href="{{ url($model->getTable()) }}"
    class="btn {{ Request::ajax() ? 'btn-sm' : '' }} btn-outline-primary px-btn"
    title="Back"
>
    <i class="fa fa-fw fa-home"></i>
</a>
