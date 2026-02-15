<nav class="navbar navbar-expand navbar-light navbar-bg">
    <a class="sidebar-toggle js-sidebar-toggle">
        <i class="hamburger align-self-center"></i>
    </a>

    <div class="navbar-collapse collapse">
        <ul class="navbar-nav navbar-align align-items-center">

            <li class="nav-item">
                <div class="user-dropdown" id="adminUserDropdown">
                    <button class="user-dropdown-toggle" onclick="toggleAdminDropdown()">
                        {{-- Foto profil, fallback ke icon --}}
                        @if(auth()->user()->photo)
                            <img src="{{ asset('storage/' . auth()->user()->photo) }}"
                                 alt="Foto Profil"
                                 class="avatar-img">
                        @else
                            <i class="bi bi-person-circle"></i>
                        @endif
                        <span>{{ auth()->user()->name ?? '' }}</span>
                        <i class="bi bi-chevron-down" style="font-size: 12px;"></i>
                    </button>

                    <div class="user-dropdown-menu">
                        <div class="user-dropdown-header">
                            <div class="user-name">{{ auth()->user()->name ?? '' }}</div>
                            <div class="user-role">{{ auth()->user()->role ?? '' }}</div>
                        </div>

                        <a href="{{ route('admin.profile.index') }}" class="user-dropdown-item">
                            <i class="bi bi-person"></i>
                            <span>Profil Saya</span>
                        </a>

                        <div class="user-dropdown-divider"></div>

                        <form action="{{ route('logout') }}" method="POST" class="logout-dropdown-form" id="adminLogoutForm">
                            @csrf
                            <button type="button" class="user-dropdown-item text-danger" id="btnAdminLogout">
                                <i class="bi bi-box-arrow-right"></i>
                                <span>Logout</span>
                            </button>
                        </form>
                    </div>
                </div>
            </li>

        </ul>
    </div>
</nav>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function toggleAdminDropdown() {
        const dropdown = document.getElementById('adminUserDropdown');
        dropdown.classList.toggle('show');
    }

    // Tutup dropdown kalau klik di luar
    document.addEventListener('click', function(event) {
        const dropdown = document.getElementById('adminUserDropdown');
        if (dropdown && !dropdown.contains(event.target)) {
            dropdown.classList.remove('show');
        }
    });

    // Konfirmasi logout
    document.addEventListener('DOMContentLoaded', function() {
        const btnLogout = document.getElementById('btnAdminLogout');
        const logoutForm = document.getElementById('adminLogoutForm');

        if (btnLogout && logoutForm) {
            btnLogout.addEventListener('click', function() {
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