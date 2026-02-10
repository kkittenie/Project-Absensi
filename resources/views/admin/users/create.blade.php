@extends('layouts.admin')

@section('title', 'Tambah Pengguna | Admin')

@section('content')
    <div class="container-fluid p-0">

        <div class="row mb-3">
            <div class="col-12">
                <h1 class="h3 mb-0">
                    <strong>Tambah Pengguna</strong> Admin
                </h1>
                <p class="text-muted">
                    Tambah Data Pengguna
                </p>
            </div>
        </div>

        <div class="card">
            <div class="card-body">

                <form action="{{ route('admin.users.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    {{-- Nama --}}
                    <div class="mb-3">
                        <label class="form-label">Nama</label>
                        <input type="text" name="name" value="{{ old('name') }}"
                            class="form-control @error('name') is-invalid @enderror">

                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Username --}}
                    <div class="mb-3">
                        <label class="form-label">Username</label>
                        <input type="text" name="username" value="{{ old('username') }}"
                            class="form-control @error('username') is-invalid @enderror">

                        @error('username')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Password --}}
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Password</label>
                            <input type="password" name="password"
                                class="form-control @error('password') is-invalid @enderror">

                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Konfirmasi Password</label>
                            <input type="password" name="password_confirmation" class="form-control">
                        </div>
                    </div>

                    {{-- Foto --}}
                    <div class="mb-3">
                        <label class="form-label">Foto</label>
                        <input type="file" name="photo" accept="image/*"
                            class="form-control @error('photo') is-invalid @enderror">

                        @error('photo')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror

                        <small class="text-muted">
                            Format: jpg, png, webp. Max 2MB.
                        </small>
                    </div>


                    {{-- Role --}}
                    <div class="mb-3">
                        <label class="form-label">Role</label>
                        <select name="role" class="form-select @error('role') is-invalid @enderror">
                            <option value="">-- Pilih Role --</option>
                            <option value="superadmin" {{ old('role') == 'superadmin' ? 'selected' : '' }}>
                                Superadmin
                            </option>
                            <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>
                                Admin
                            </option>
                            <option value="user" {{ old('role') == 'user' ? 'selected' : '' }}>
                                User
                            </option>
                        </select>

                        @error('role')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Status --}}
                    <div class="mb-4">
                        <label class="form-label">Status</label>
                        <select name="is_active" class="form-select">
                            <option value="1" selected>Aktif</option>
                            <option value="0">Nonaktif</option>
                        </select>
                    </div>

                    {{-- Action --}}
                    <div class="d-flex justify-content-end">
                        <a href="{{ route('admin.users.index') }}" class="btn btn-secondary me-2">
                            Batal
                        </a>
                        <button class="btn btn-primary">
                            Simpan
                        </button>
                    </div>

                </form>

            </div>
        </div>

    </div>
@endsection
