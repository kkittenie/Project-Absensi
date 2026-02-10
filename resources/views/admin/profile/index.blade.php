@extends('layouts.admin')

@section('title', 'Profile | Admin')

@section('content')
    <div class="container-fluid p-0">

        <div class="row mb-3">
            <div class="col-12">
                <h1 class="h3 mb-0">
                    <strong>Profil</strong> Admin
                </h1>
                <p class="text-muted">
                    Ringkasan data profil
                </p>
            </div>
        </div>

        <div class="row">
            {{-- LEFT : PROFILE CARD --}}
            <div class="col-md-4 col-xl-3">
                <div class="card mb-3">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Detail Profil</h5>
                    </div>

                    <div class="card-body text-center">
                        <div class="profile-avatar-wrapper mb-3">
                            <img id="profilePreview"
                                src="{{ auth()->user()->photo
                                    ? asset('storage/' . auth()->user()->photo)
                                    : asset('assets/admin/img/avatars/default.jpg') }}"
                                alt="Profile Photo" class="profile-avatar">
                        </div>

                        <h5 class="card-title mb-0">
                            {{ auth()->user()->name }}
                        </h5>

                        <div class="text-muted mb-2">
                            Hak Akses: {{ auth()->user()->role }}
                        </div>
                    </div>

                    <hr class="my-0">

                    <div class="card-body">
                        <h5 class="h6 card-title">Info Akun</h5>
                        <ul class="list-unstyled mb-0">
                            <li class="mb-2">
                                <strong>Username:</strong><br>
                                {{ auth()->user()->username }}
                            </li>
                            <li>
                                <strong>Hak Akses:</strong><br>
                                {{ auth()->user()->role }}
                            </li>
                            <li>
                                <strong>Tanggal Akun Dibuat:</strong><br>
                                {{ auth()->user()->created_at }}
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            {{-- RIGHT : FORM UPDATE --}}
            <div class="col-md-8 col-xl-9">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Edit Profil</h5>
                    </div>

                    <div class="card-body">
                        @if ($errors->any())
                            <x-alert type="danger" title="Edit Gagal">
                                <ul class="mb-0 ps-3">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </x-alert>
                        @endif

                        @if (session('success'))
                            <x-alert type="success">
                                {{ session('success') }}
                            </x-alert>
                        @endif

                        <form action="{{ route('admin.profile.update') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            {{-- NAME --}}
                            <div class="mb-3">
                                <label class="form-label">Nama Lengkap</label>
                                <input type="text" name="name" class="form-control"
                                    value="{{ old('name', auth()->user()->name) }}">
                            </div>

                            {{-- USERNAME --}}
                            <div class="mb-3">
                                <label class="form-label">Username</label>
                                <input type="text" name="username" class="form-control"
                                    value="{{ old('username', auth()->user()->username) }}">
                            </div>

                            {{-- PHOTO --}}
                            <div class="mb-3">
                                <label class="form-label">Foto Profil</label>
                                <input type="file" name="photo" class="form-control">
                            </div>

                            <hr>

                            {{-- PASSWORD --}}
                            <div class="mb-3">
                                <label class="form-label">Password Baru</label>
                                <input type="password" name="password" class="form-control">
                                <small class="text-muted">
                                    Kosongkan jika tidak ingin mengganti password
                                </small>
                            </div>

                            <div class="text-end">
                                <button type="submit" class="btn btn-primary">
                                    Simpan Perubahan
                                </button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>

        </div>

    </div>
    @push('scripts')
        <script>
            document.querySelector('input[name="photo"]').addEventListener('change', function(e) {
                const file = e.target.files[0];
                if (!file) return;

                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('profilePreview').src = e.target.result;
                };
                reader.readAsDataURL(file);
            });
        </script>
    @endpush
@endsection
