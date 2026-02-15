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

                <form action="{{ route('admin.guru.store') }}" method="POST" enctype="multipart/form-data" id="formTambahGuru">
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

                    {{-- Email Guru --}}
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" value="{{ old('email') }}" class="form-control @error('email') is-invalid @enderror">

                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Mapel --}}
                    <div class="mb-3">
                        <label class="form-label">Mata Pelajaran</label>

                        <select name="mapel_id" class="form-select @error('mapel_id') is-invalid @enderror">

                            <option value="">-- Pilih Mapel --</option>

                            @foreach ($mapels as $mapel)
                                <option value="{{ $mapel->id }}" {{ old('mapel_id') == $mapel->id ? 'selected' : '' }}>
                                    {{ $mapel->nama_mapel }}
                                </option>
                            @endforeach

                        </select>

                        @error('mapel_id')
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
                            <option value="1" {{ old('is_active', 1) == 1 ? 'selected' : '' }}>
                                Aktif
                            </option>
                            <option value="0" {{ old('is_active') == 0 ? 'selected' : '' }}>
                                Nonaktif
                            </option>
                        </select>
                    </div>

                    {{-- Action --}}
                    <div class="d-flex justify-content-end">
                        <a href="{{ route('admin.guru.index') }}" class="btn btn-secondary me-2" id="btnBatal">
                            Batal
                        </a>
                        <button type="submit" class="btn btn-primary">
                            Simpan
                        </button>
                    </div>

                </form>

            </div>
        </div>

    </div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Konfirmasi sebelum submit form
        document.getElementById('formTambahGuru').addEventListener('submit', function(e) {
            e.preventDefault();
            
            Swal.fire({
                title: 'Konfirmasi',
                text: 'Apakah Anda yakin ingin menyimpan data guru ini?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Simpan!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    this.submit();
                }
            });
        });

        // Konfirmasi sebelum batal
        document.getElementById('btnBatal').addEventListener('click', function(e) {
            e.preventDefault();
            const url = this.getAttribute('href');
            
            Swal.fire({
                title: 'Konfirmasi',
                text: 'Apakah Anda yakin ingin membatalkan? Data yang diinput akan hilang.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, Batalkan!',
                cancelButtonText: 'Tidak'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = url;
                }
            });
        });

        // Alert jika ada error validasi
        @if ($errors->any())
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Terdapat kesalahan pada form. Silakan periksa kembali.',
                confirmButtonText: 'OK'
            });
        @endif
    });
</script>
@endpush