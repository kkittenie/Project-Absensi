@extends('layouts.admin')

@section('title', 'Edit Pengguna | Admin')

@section('content')
    <div class="container-fluid p-0">

        <div class="row mb-3">
            <div class="col-12">
                <h1 class="h3 mb-0">
                    <strong>Edit Pengguna</strong> Admin
                </h1>
                <p class="text-muted">
                    Edit Data Pengguna
                </p>
            </div>
        </div>

        <div class="card">
            <div class="card-body">

                <form action="{{ route('admin.user.update', $user->uuid) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    {{-- Nama --}}
                    <div class="mb-3">
                        <label class="form-label">Nama</label>
                        <input type="text" name="name" value="{{ old('name', $user->name) }}"
                            class="form-control @error('name') is-invalid @enderror">
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Username --}}
                    <div class="mb-3">
                        <label class="form-label">Username</label>
                        <input type="text" name="username" value="{{ old('username', $user->username) }}"
                            class="form-control @error('username') is-invalid @enderror">
                        @error('username')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Foto --}}
                    <div class="mb-3">
                        <label class="form-label">Foto</label>
                        <input type="file" name="photo" class="form-control @error('photo') is-invalid @enderror">

                        @error('photo')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror

                        @if ($user->photo)
                            <div class="mt-2">
                                <img src="{{ asset('storage/' . $user->photo) }}" width="100" height="100"
                                    class="rounded-2 object-fit-cover">
                            </div>
                        @endif
                    </div>

                    {{-- Password --}}
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Password (opsional)</label>
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

                    {{-- Role --}}
                    <div class="mb-3">
                        <label class="form-label">Role</label>
                        <select name="role" class="form-select">
                            <option value="superadmin" {{ $user->role == 'superadmin' ? 'selected' : '' }}>
                                Superadmin
                            </option>
                            <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>
                                Admin
                            </option>
                        </select>
                    </div>

                    {{-- Status --}}
                    <div class="mb-4">
                        <label class="form-label">Status</label>
                        <select name="is_active" class="form-select">
                            <option value="1" {{ $user->is_active ? 'selected' : '' }}>Aktif</option>
                            <option value="0" {{ !$user->is_active ? 'selected' : '' }}>Nonaktif</option>
                        </select>
                    </div>

                    {{-- Action --}}
                    <div class="d-flex justify-content-end">
                        <a href="{{ route('admin.user.index') }}" class="btn btn-secondary me-2">
                            Batal
                        </a>
                        <button class="btn btn-primary">
                            Update
                        </button>
                    </div>

                </form>

            </div>
        </div>

    </div>
@endsection
