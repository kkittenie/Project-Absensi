<header id="header" class="header d-flex align-items-center fixed-top">
    <div class="container-fluid container-xl d-flex align-items-center">

        <a href="{{ route('landing.index') }}" class="logo d-flex align-items-center me-auto">
            <img src="{{ asset('assets/landing/img/logo.png') }}" alt="Logo">
            <h1 class="sitename">SiHadir</h1>
        </a>

        <nav id="navmenu" class="navmenu">
            <ul>
                <li><a href="{{ route('landing.index') }}#hero" class="active">Beranda</a></li>
                <li><a href="{{ route('landing.index') }}#about">Tentang Kami</a></li>
                <li><a href="{{ route('landing.index') }}#contact">Kontak</a></li>
            </ul>
            <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
        </nav>

        @if (auth()->check())
            <a href="{{ route('admin.dashboard') }}" class="btn-getstarted">
                Dashboard
            </a>
        @else
            <a href="{{ route('login') }}" class="btn-getstarted">
                Login
            </a>
        @endif
    </div>
</header>
