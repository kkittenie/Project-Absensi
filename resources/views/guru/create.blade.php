@extends('layouts.admin')

@section('title', 'Tambah Guru | Admin')

@section('content')
    <div class="container-fluid p-0">

        <div class="row mb-3">
            <div class="col-12">
                <h1 class="h3 mb-0">
                    <strong>Tambah Guru</strong>
                </h1>
                <p class="text-muted">
                    Tambah Data Guru
                </p>
            </div>
        </div>

        <div class="card">
            <div class="card-body">

                <form action="{{ route('admin.guru.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    {{-- Nama Guru --}}
                    <div class="mb-3">
                        <label class="form-label">Nama Guru</label>
                        <input type="text" name="nama_guru" value="{{ old('nama_guru') }}"
                            class="form-control @error('nama_guru') is-invalid @enderror">

                        @error('nama_guru')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Mata Pelajaran --}}
                    <div class="mb-3">
                        <label class="form-label">Mata Pelajaran</label>
                        <input type="text" name="mata_pelajaran" value="{{ old('mata_pelajaran') }}"
                            class="form-control @error('mata_pelajaran') is-invalid @enderror">

                        @error('mata_pelajaran')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- NIP --}}
                    <div class="mb-3">
                        <label class="form-label">NIP</label>
                        <input type="text" name="nip" value="{{ old('nip') }}"
                            class="form-control @error('nip') is-invalid @enderror">

                        @error('nip')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Nomor Telepon --}}
                    <div class="mb-3">
                        <label class="form-label">Nomor Telepon</label>
                        <input type="text" name="nomor_telepon" value="{{ old('nomor_telepon') }}"
                            class="form-control @error('nomor_telepon') is-invalid @enderror">

                        @error('nomor_telepon')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
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
                        <a href="{{ route('admin.guru.index') }}" class="btn btn-secondary me-2">
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