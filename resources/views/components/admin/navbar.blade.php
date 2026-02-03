<nav class="navbar navbar-expand navbar-light navbar-bg">
    <a class="sidebar-toggle js-sidebar-toggle">
        <i class="hamburger align-self-center"></i>
    </a>

    <div class="navbar-collapse collapse">
        <ul class="navbar-nav navbar-align">

            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle d-none d-sm-inline-block" href="#" data-bs-toggle="dropdown">
                    @if (auth()->user()->photo)
                        <img src="{{ asset('storage/' . auth()->user()->photo) }}"
                            class="avatar img-fluid rounded me-1 object-fit-cover rounded-2" width="32"
                            height="32">
                    @endif
                    <span class="text-dark">{{ auth()->user()->name ?? '' }}</span>
                </a>

                <div class="dropdown-menu dropdown-menu-end">
                    <a class="dropdown-item" href="{{ route('admin.profile.index') }}">
                        <i class="align-middle me-1" data-feather="user"></i>
                        Profile
                    </a>

                    <div class="dropdown-divider"></div>

                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button class="dropdown-item text-danger">
                            <i class="align-middle me-1" data-feather="log-out"></i>
                            Logout
                        </button>
                    </form>
                </div>
            </li>

        </ul>
    </div>
</nav>
