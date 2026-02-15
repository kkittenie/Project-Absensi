<header id="header" class="header d-flex align-items-center fixed-top">
    <div class="container-fluid container-xl d-flex align-items-center">

        <a href="{{ route('landing.index') }}" class="logo d-flex align-items-center me-auto">
            <img src="{{ asset('assets/landing/img/logo.png') }}" alt="Logo">
            <h1 class="sitename">SiHadir Guru</h1>
        </a>

        <nav id="navmenu" class="navmenu">
            <ul>
                <li><a href="{{ route('landing.index') }}#hero" class="active">Beranda</a></li>
                <li><a href="{{ route('landing.index') }}#about">Tentang Kami</a></li>
                <li><a href="{{ route('landing.index') }}#contact">Kontak</a></li>
            </ul>
            <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
        </nav>

        {{-- Cek login untuk admin --}}
        @if(auth('web')->check() && auth('web')->user()->hasAnyRole(['admin','superadmin']))
            <div class="user-dropdown" id="userDropdown">
                <button class="user-dropdown-toggle" onclick="toggleDropdown()">
                    {{-- Foto profil admin, fallback ke icon kalau belum upload --}}
                    @if(auth('web')->user()->photo)
                        <img src="{{ asset('storage/' . auth('web')->user()->photo) }}"
                             alt="Foto Profil"
                             class="avatar-img">
                    @else
                        <i class="bi bi-person-circle"></i>
                    @endif
                    <span>{{ auth('web')->user()->name }}</span>
                    <i class="bi bi-chevron-down" style="font-size: 12px;"></i>
                </button>
                
                <div class="user-dropdown-menu">
                    <div class="user-dropdown-header">
                        <div class="user-name">{{ auth('web')->user()->name }}</div>
                        <div class="user-role">{{ auth('web')->user()->role }}</div>
                    </div>
                    
                    <a href="{{ route('admin.dashboard') }}" class="user-dropdown-item">
                        <i class="bi bi-speedometer2"></i>
                        <span>Dashboard</span>
                    </a>
                    
                    <a href="{{ route('admin.profile.index') }}" class="user-dropdown-item">
                        <i class="bi bi-person"></i>
                        <span>Profil Saya</span>
                    </a>
                    
                    <div class="user-dropdown-divider"></div>
                    
                    <form action="{{ route('logout') }}" method="POST" class="logout-dropdown-form" id="logoutForm">
                        @csrf
                        <button type="submit" class="user-dropdown-item">
                            <i class="bi bi-box-arrow-right"></i>
                            <span>Logout</span>
                        </button>
                    </form>
                </div>
            </div>
            
        {{-- Cek login untuk guru --}}
        @elseif(auth('guru')->check())
            <div class="user-dropdown" id="userDropdown">
                <button class="user-dropdown-toggle" onclick="toggleDropdown()">
                    {{-- Foto profil guru, fallback ke icon kalau belum upload --}}
                    @if(auth('guru')->user()->photo)
                        <img src="{{ asset('storage/' . auth('guru')->user()->photo) }}"
                             alt="Foto Profil"
                             class="avatar-img">
                    @else
                        <i class="bi bi-person-circle"></i>
                    @endif
                    <span>{{ auth('guru')->user()->nama_guru }}</span>
                    <i class="bi bi-chevron-down" style="font-size: 12px;"></i>
                </button>
                
                <div class="user-dropdown-menu">
                    <div class="user-dropdown-header">
                        <div class="user-name">{{ auth('guru')->user()->nama_guru }}</div>
                        <div class="user-role">Guru</div>
                    </div>
                    
                    <a href="{{ route('guru.profile.index') }}" class="user-dropdown-item">
                        <i class="bi bi-person"></i>
                        <span>Profil Saya</span>
                    </a>
                    
                    <div class="user-dropdown-divider"></div>
                    
                    <form action="{{ route('guru.logout') }}" method="POST" class="logout-dropdown-form" id="logoutFormGuru">
                        @csrf
                        <button type="submit" class="user-dropdown-item">
                            <i class="bi bi-box-arrow-right"></i>
                            <span>Logout</span>
                        </button>
                    </form>
                </div>
            </div>
            
        {{-- Kalau belum login --}}
        @else
            <a href="{{ route('login') }}" class="btn-getstarted">
                Login
            </a>
        @endif

    </div>
</header>

{{-- JavaScript untuk Dropdown & Sweet Alert --}}
@if(auth('web')->check() || auth('guru')->check())
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // Toggle Dropdown
        function toggleDropdown() {
            const dropdown = document.getElementById('userDropdown');
            dropdown.classList.toggle('show');
        }
        
        // Close dropdown when clicking outside
        document.addEventListener('click', function(event) {
            const dropdown = document.getElementById('userDropdown');
            const toggle = dropdown?.querySelector('.user-dropdown-toggle');
            
            if (dropdown && !dropdown.contains(event.target)) {
                dropdown.classList.remove('show');
            }
        });
        
        // Prevent dropdown close when clicking inside
        document.querySelector('.user-dropdown-menu')?.addEventListener('click', function(e) {
            e.stopPropagation();
        });
        
        // Sweet Alert untuk Logout
        document.addEventListener('DOMContentLoaded', function() {
            const logoutForm = document.getElementById('logoutForm') || document.getElementById('logoutFormGuru');
            
            if (logoutForm) {
                logoutForm.addEventListener('submit', function(e) {
                    e.preventDefault();
                    
                    Swal.fire({
                        title: 'Konfirmasi Logout',
                        text: 'Apakah Anda yakin ingin keluar?',
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonColor: '#47b2e4',
                        cancelButtonColor: '#6c757d',
                        confirmButtonText: 'Ya, Logout!',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            logoutForm.submit();
                        }
                    });
                });
            }
        });
    </script>
@endif