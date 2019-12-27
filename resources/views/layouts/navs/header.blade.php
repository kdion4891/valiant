<li class="nav-item dropdown">
    <a class="nav-link" data-toggle="dropdown" href="#">
        <i class="fa fa-user"></i>
    </a>
    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
        <span class="dropdown-header">{{ Auth::user()->name }}</span>
        <div class="dropdown-divider"></div>
        <a href="{{ url('profile/edit') }}" class="dropdown-item">
            <i class="fa fa-fw fa-edit mr-2"></i> Edit Profile
        </a>
        <div class="dropdown-divider"></div>
        <a href="{{ url('profile/password') }}" class="dropdown-item">
            <i class="fa fa-fw fa-lock mr-2"></i> Change Password
        </a>
        <div class="dropdown-divider"></div>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button class="dropdown-item">
                <i class="fa fa-fw fa-sign-out-alt mr-2"></i> Logout
            </button>
        </form>
    </div>
</li>
