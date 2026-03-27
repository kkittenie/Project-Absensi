@extends('layouts.auth')

@section('title', 'Login | SiHadir Guru')

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/login/login.css') }}">
@endpush

@section('content')
    <div class="login-page">
        <div class="login-container">
            <div class="login-header">
                <div class="login-logo">
                    <img src="{{ asset('assets/landing/img/logo.png') }}" alt="Logo">
                </div>
                <h1>Selamat Datang!</h1>
                <p>Masuk untuk melanjutkan ke sistem</p>
            </div>

            <div class="card login-card border-0">
                <div class="card-body">
                    <form method="POST" action="{{ route('login') }}" id="formLogin">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label">Username / NIP</label>
                            <input class="form-control form-control-lg" type="text" name="identifier"
                                value="{{ old('identifier') }}" placeholder="Masukkan Username atau NIP"
                                required autofocus>
                            <small class="text-muted">
                                Admin masukkan <strong>username</strong>, Guru masukkan <strong>NIP</strong>
                            </small>
                            @error('identifier')
                                <div class="text-danger mt-1" style="font-size: 0.875rem;">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Password</label>
                            <div class="input-group">
                                <input class="form-control form-control-lg" type="password" name="password"
                                    id="inputPassword" placeholder="Masukkan Password" required>
                                <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                                    <i class="bi bi-eye" id="eyeIcon"></i>
                                </button>
                            </div>
                            @error('password')
                                <div class="text-danger mt-1" style="font-size: 0.875rem;">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="remember" id="remember"
                                    {{ old('remember') ? 'checked' : '' }}>
                                <label class="form-check-label" for="remember">
                                    Ingat Saya
                                </label>
                            </div>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-login">
                                <i class="bi bi-box-arrow-in-right"></i> Masuk
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="back-link">
                <a href="{{ route('landing.index') }}">
                    <i class="bi bi-arrow-left"></i> Kembali ke Landing Page
                </a>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            const togglePassword = document.getElementById('togglePassword');
            const inputPassword  = document.getElementById('inputPassword');
            const eyeIcon        = document.getElementById('eyeIcon');

            if (togglePassword) {
                togglePassword.addEventListener('click', function() {
                    const isPassword = inputPassword.type === 'password';
                    inputPassword.type = isPassword ? 'text' : 'password';
                    eyeIcon.classList.toggle('bi-eye', !isPassword);
                    eyeIcon.classList.toggle('bi-eye-slash', isPassword);
                });
            }

            @if (session('success'))
                Swal.fire({
                    icon: 'success',
                    title: '{{ session('success') }}',
                    showConfirmButton: false,
                    timer: 2500,
                    timerProgressBar: true,
                    background: '#fff'
                });
            @endif

            @if ($errors->any())
                Swal.fire({
                    icon: 'error',
                    title: 'Login Gagal!',
                    html: '<ul class="text-start mb-0" style="list-style-position: inside;">' +
                        @foreach ($errors->all() as $error)
                            '<li>{{ $error }}</li>' +
                        @endforeach
                        '</ul>',
                    confirmButtonText: 'OK',
                    confirmButtonColor: '#47b2e4',
                    background: '#fff'
                });
            @endif

            const formLogin = document.getElementById('formLogin');
            if (formLogin) {
                formLogin.addEventListener('submit', function() {
                    Swal.fire({
                        title: 'Memproses...',
                        text: 'Mohon tunggu sebentar',
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        allowEnterKey: false,
                        background: '#fff',
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });
                });
            }

        });
    </script>
@endpush