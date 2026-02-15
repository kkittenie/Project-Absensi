@extends('layouts.landing')

@section('title', 'Profil Saya')

@section('content')

    @push('styles')
        <link rel="stylesheet" href="{{ asset('assets/profile/profile.css') }}">
    @endpush

    <section class="profile-section">
        <div class="profile-container container">

            <div class="profile-header">
                <h1>Profil Saya</h1>
                <p>Kelola informasi profil Anda</p>
            </div>

            <div class="profile-card">
                <div class="row g-0">

                    {{-- SIDEBAR: Profile Info --}}
                    <div class="col-lg-4">
                        <div class="profile-sidebar">

                            <div class="profile-avatar-wrapper">
                                @if(auth('guru')->check())
                                                        {{-- Foto Guru --}}
                                                        <img id="profilePreview" src="{{ auth('guru')->user()->photo
                                    ? asset('storage/' . auth('guru')->user()->photo)
                                    : asset('assets/admin/img/avatars/default.jpg') }}" alt="Profile Photo"
                                                            class="profile-avatar">
                                @else
                                                        {{-- Foto Admin --}}
                                                        <img id="profilePreview" src="{{ auth()->user()->photo
                                    ? asset('storage/' . auth()->user()->photo)
                                    : asset('assets/admin/img/avatars/default.jpg') }}" alt="Profile Photo"
                                                            class="profile-avatar">
                                @endif
                                <label for="photoInput" class="profile-avatar-edit">
                                    <i class="bi bi-camera"></i>
                                </label>
                            </div>

                            @if(auth('guru')->check())
                                {{-- Info Guru --}}
                                <div class="profile-name">{{ auth('guru')->user()->nama_guru }}</div>
                                <div class="profile-role">Guru</div>

                                <div class="profile-info">
                                    <div class="profile-info-title">
                                        <i class="bi bi-info-circle"></i>
                                        <span>Informasi Akun</span>
                                    </div>

                                    <div class="profile-info-item">
                                        <div class="profile-info-label">NIP</div>
                                        <div class="profile-info-value">{{ auth('guru')->user()->nip }}</div>
                                    </div>

                                    <div class="profile-info-item">
                                        <div class="profile-info-label">Email</div>
                                        <div class="profile-info-value">{{ auth('guru')->user()->email ?? '-' }}</div>
                                    </div>

                                    <div class="profile-info-item">
                                        <div class="profile-info-label">Mata Pelajaran</div>
                                        <div class="profile-info-value">{{ auth('guru')->user()->mapel->nama_mapel ?? '-' }}
                                        </div>
                                    </div>

                                    <div class="profile-info-item">
                                        <div class="profile-info-label">No. Telepon</div>
                                        <div class="profile-info-value">{{ auth('guru')->user()->nomor_telepon ?? '-' }}</div>
                                    </div>
                                </div>
                            @else
                                {{-- Info Admin --}}
                                <div class="profile-name">{{ auth()->user()->name }}</div>
                                <div class="profile-role">{{ auth()->user()->role }}</div>

                                <div class="profile-info">
                                    <div class="profile-info-title">
                                        <i class="bi bi-info-circle"></i>
                                        <span>Informasi Akun</span>
                                    </div>

                                    <div class="profile-info-item">
                                        <div class="profile-info-label">Username</div>
                                        <div class="profile-info-value">{{ auth()->user()->username }}</div>
                                    </div>

                                    <div class="profile-info-item">
                                        <div class="profile-info-label">Hak Akses</div>
                                        <div class="profile-info-value">{{ auth()->user()->role }}</div>
                                    </div>

                                    <div class="profile-info-item">
                                        <div class="profile-info-label">Bergabung Sejak</div>
                                        <div class="profile-info-value">{{ auth()->user()->created_at->format('d M Y') }}</div>
                                    </div>
                                </div>
                            @endif

                        </div>
                    </div>

                    {{-- CONTENT: Edit Form --}}
                    <div class="col-lg-8">
                        <div class="profile-content">

                            <div class="profile-form-title">
                                <i class="bi bi-pencil-square"></i>
                                <span>Edit Profil</span>
                            </div>

                            @if(auth('guru')->check())
                                {{-- FORM GURU --}}
                                <form action="{{ route('guru.profile.update') }}" method="POST" enctype="multipart/form-data"
                                    id="profileForm">
                                    @csrf
                                    @method('PUT')

                                    {{-- NAMA GURU --}}
                                    <div class="form-group">
                                        <label class="form-label">Nama Lengkap</label>
                                        <input type="text" name="nama_guru"
                                            class="form-control @error('nama_guru') is-invalid @enderror"
                                            value="{{ old('nama_guru', auth('guru')->user()->nama_guru) }}">
                                        @error('nama_guru')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    {{-- EMAIL --}}
                                    <div class="form-group">
                                        <label class="form-label">Email</label>
                                        <input type="email" name="email"
                                            class="form-control @error('email') is-invalid @enderror"
                                            value="{{ old('email', auth('guru')->user()->email) }}">
                                        @error('email')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    {{-- NO TELEPON --}}
                                    <div class="form-group">
                                        <label class="form-label">Nomor Telepon</label>
                                        <input type="text" name="nomor_telepon"
                                            class="form-control @error('nomor_telepon') is-invalid @enderror"
                                            value="{{ old('nomor_telepon', auth('guru')->user()->nomor_telepon) }}">
                                        @error('nomor_telepon')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    {{-- PHOTO --}}
                                    <div class="form-group">
                                        <label class="form-label">Foto Profil</label>
                                        <input type="file" name="photo" id="photoInput"
                                            class="form-control @error('photo') is-invalid @enderror" accept="image/*">
                                        <small class="form-text">Format: JPG, PNG, WebP. Maksimal 2MB.</small>
                                        @error('photo')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <hr class="form-divider">

                                    {{-- PASSWORD --}}
                                    <div class="form-group">
                                        <label class="form-label">Password Baru (Opsional)</label>
                                        <input type="password" name="password"
                                            class="form-control @error('password') is-invalid @enderror">
                                        <small class="form-text">Kosongkan jika tidak ingin mengganti password</small>
                                        @error('password')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="d-flex gap-2 justify-content-end">
                                        <a href="{{ url()->previous() }}" class="btn btn-secondary-custom">
                                            <i class="bi bi-x-circle me-2"></i>Batal
                                        </a>
                                        <button type="submit" class="btn btn-primary-custom">
                                            <i class="bi bi-check-circle me-2"></i>Simpan Perubahan
                                        </button>
                                    </div>
                                </form>
                            @else
                                {{-- FORM ADMIN --}}
                                <form action="{{ route('admin.profile.update') }}" method="POST" enctype="multipart/form-data"
                                    id="profileForm">
                                    @csrf
                                    @method('PUT')

                                    {{-- NAME --}}
                                    <div class="form-group">
                                        <label class="form-label">Nama Lengkap</label>
                                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                                            value="{{ old('name', auth()->user()->name) }}">
                                        @error('name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    {{-- USERNAME --}}
                                    <div class="form-group">
                                        <label class="form-label">Username</label>
                                        <input type="text" name="username"
                                            class="form-control @error('username') is-invalid @enderror"
                                            value="{{ old('username', auth()->user()->username) }}">
                                        @error('username')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    {{-- PHOTO --}}
                                    <div class="form-group">
                                        <label class="form-label">Foto Profil</label>
                                        <input type="file" name="photo" id="photoInput"
                                            class="form-control @error('photo') is-invalid @enderror" accept="image/*">
                                        <small class="form-text">Format: JPG, PNG, WebP. Maksimal 2MB.</small>
                                        @error('photo')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <hr class="form-divider">

                                    {{-- PASSWORD --}}
                                    <div class="form-group">
                                        <label class="form-label">Password Baru (Opsional)</label>
                                        <input type="password" name="password"
                                            class="form-control @error('password') is-invalid @enderror">
                                        <small class="form-text">Kosongkan jika tidak ingin mengganti password</small>
                                        @error('password')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="d-flex gap-2 justify-content-end">
                                        <a href="{{ url()->previous() }}" class="btn btn-secondary-custom">
                                            <i class="bi bi-x-circle me-2"></i>Batal
                                        </a>
                                        <button type="submit" class="btn btn-primary-custom">
                                            <i class="bi bi-check-circle me-2"></i>Simpan Perubahan
                                        </button>
                                    </div>
                                </form>
                            @endif

                        </div>
                    </div>

                </div>
            </div>

        </div>
    </section>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {

            // Preview foto sebelum upload
            document.getElementById('photoInput').addEventListener('change', function (e) {
                const file = e.target.files[0];
                if (!file) return;

                // Validasi ukuran file (max 2MB)
                if (file.size > 2 * 1024 * 1024) {
                    Swal.fire({
                        icon: 'error',
                        title: 'File Terlalu Besar',
                        text: 'Ukuran foto maksimal 2MB',
                        confirmButtonColor: '#47b2e4'
                    });
                    this.value = '';
                    return;
                }

                const reader = new FileReader();
                reader.onload = function (e) {
                    document.getElementById('profilePreview').src = e.target.result;
                };
                reader.readAsDataURL(file);
            });

            // Alert Success
            @if (session('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: '{{ session('success') }}',
                    showConfirmButton: false,
                    timer: 2500,
                    timerProgressBar: true
                });
            @endif

            // Alert Error
            @if ($errors->any())
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal!',
                    html: '<ul class="text-start mb-0" style="list-style-position: inside;">' +
                        @foreach ($errors->all() as $error)
                            '<li>{{ $error }}</li>' +
                        @endforeach
                        '</ul>',
                    confirmButtonText: 'OK',
                    confirmButtonColor: '#47b2e4'
                });
            @endif

            // Konfirmasi sebelum submit
            document.getElementById('profileForm').addEventListener('submit', function (e) {
                e.preventDefault();

                Swal.fire({
                    title: 'Konfirmasi',
                    text: 'Apakah Anda yakin ingin menyimpan perubahan?',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#47b2e4',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Ya, Simpan!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        this.submit();
                    }
                });
            });

        });
    </script>
@endpush