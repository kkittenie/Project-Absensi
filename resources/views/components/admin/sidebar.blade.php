<nav id="sidebar" class="sidebar js-sidebar">
    <div class="sidebar-content js-simplebar">

        <a class="sidebar-brand" href="{{ route('admin.dashboard') }}">
            <span class="align-middle">SiHadir Admin</span>
        </a>

        <ul class="sidebar-nav">

            <li class="sidebar-header">Main</li>

            <li class="sidebar-item {{ request()->routeIs('admin') ? 'active' : '' }}">
                <a class="sidebar-link" href="{{ route('admin.dashboard') }}">
                    <i class="align-middle" data-feather="sliders"></i>
                    <span class="align-middle">Dashboard</span>
                </a>
            </li>

            <li class="sidebar-header">Management</li>

            @role('superadmin')
            <li class="sidebar-item {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                <a class="sidebar-link" href="{{ route('admin.users.index') }}">
                    <i class="align-middle" data-feather="users"></i>
                    <span class="align-middle">Daftar Admin</span>
                </a>
            </li>
            @endrole

            @role('superadmin')
            <li class="sidebar-item {{ request()->routeIs('admin.guru.*') ? 'active' : '' }}">
                <a class="sidebar-link" href="{{ route('admin.guru.index') }}">
                    <i class="align-middle" data-feather="user"></i>
                    <span class="align-middle">Daftar Guru</span>
                </a>
            </li>
            @endrole
<<<<<<< HEAD
            @role('superadmin')
            <li class="sidebar-item {{ request()->routeIs('admin.waktu.*') ? 'active' : '' }}">
                <a class="sidebar-link" href="{{ route('admin.waktu.index') }}">
                    <i class="align-middle" data-feather="user"></i>
                    <span class="align-middle">Pengaturan Waktu</span>
=======

            @role('superadmin')
            <li class="sidebar-item {{ request()->routeIs('admin.perizinan.*') ? 'active' : '' }}">
                <a class="sidebar-link" href="{{ route('admin.perizinan.index') }}">
                    <i class="align-middle" data-feather="file-text"></i>
                    <span class="align-middle">Daftar Perizinan</span>
>>>>>>> e089b05499cbd155a4be97c6a4336bffa879b434
                </a>
            </li>
            @endrole
        </ul>
    </div>
</nav>