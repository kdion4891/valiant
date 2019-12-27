<li class="nav-item">
    <a
        class="nav-link {{ Request::is($model->getTable() . '/details/' . $model->id) ? 'active' : '' }}"
        href="{{ url($model->getTable() . '/details/' . $model->id) }}"
        role="tab"
    >
        Details
    </a>
</li>
