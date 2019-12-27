@can('Admin')
    <li class="nav-item">
        <a href="{{ url('users') }}" class="nav-link {{ Request::is('users') ? 'active' : '' }}">
            <i class="nav-icon fa fa-users"></i>
            <p>Users</p>
        </a>
    </li>
    <li class="nav-item">
        <a href="{{ url('logs') }}" class="nav-link {{ Request::is('logs') ? 'active' : '' }}">
            <i class="nav-icon fa fa-file-alt"></i>
            <p>Logs</p>
        </a>
    </li>
@endcan
