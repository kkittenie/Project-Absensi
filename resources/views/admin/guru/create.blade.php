@extends('layouts.admin')

@section('title', 'Tambah Guru | Admin')

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/admin/css/guru.css') }}">
@endpush

@section('content')
    <div class="container-fluid p-0">

        <div class="page-header row mb-4">
            <div class="col-12">
                <h1 class="h3 mb-0"><strong>Tambah</strong> Guru</h1>
                <p class="text-muted mb-0">Tambah data guru baru</p>
            </div>
        </div>

        <div class="card">
            <div class="card-body">

                <form action="{{ route('admin.guru.store') }}" method="POST" enctype="multipart/form-data" id="formTambahGuru">
                    @csrf

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Nama Guru</label>
                            <input type="text" name="nama_guru" value="{{ old('nama_guru') }}"
                                class="form-control @error('nama_guru') is-invalid @enderror"
                                placeholder="Masukkan nama lengkap">
                            @error('nama_guru')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" value="{{ old('email') }}"
                                class="form-control @error('email') is-invalid @enderror"
                                placeholder="Masukkan email">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">NIP</label>
                            <input type="text" name="nip" value="{{ old('nip') }}"
                                class="form-control @error('nip') is-invalid @enderror"
                                placeholder="Masukkan NIP">
                            @error('nip')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Nomor Telepon</label>
                            <input type="text" name="nomor_telepon" value="{{ old('nomor_telepon') }}"
                                class="form-control @error('nomor_telepon') is-invalid @enderror"
                                placeholder="Masukkan nomor telepon">
                            @error('nomor_telepon')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
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

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Status</label>
                            <select name="is_active" class="form-select">
                                <option value="1" {{ old('is_active', 1) == 1 ? 'selected' : '' }}>Aktif</option>
                                <option value="0" {{ old('is_active') == 0 ? 'selected' : '' }}>Nonaktif</option>
                            </select>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label">Foto</label>
                        <input type="file" name="photo" accept="image/*"
                            class="form-control @error('photo') is-invalid @enderror">
                        <small class="text-muted">Format: jpg, png, webp. Max 2MB.</small>
                        @error('photo')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <hr>

                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('admin.guru.index') }}" class="btn btn-secondary" id="btnBatal">
                            Batal
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i data-feather="save" style="width:16px;height:16px;"></i> Simpan
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

        document.getElementById('formTambahGuru').addEventListener('submit', function(e) {
            e.preventDefault();
            Swal.fire({
                title: 'Konfirmasi',
                text: 'Apakah Anda yakin ingin menyimpan data guru ini?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#47b2e4',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, Simpan!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) this.submit();
            });
        });

        document.getElementById('btnBatal').addEventListener('click', function(e) {
            e.preventDefault();
            const url = this.getAttribute('href');
            Swal.fire({
                title: 'Konfirmasi',
                text: 'Apakah Anda yakin ingin membatalkan? Data yang diinput akan hilang.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, Batalkan!',
                cancelButtonText: 'Tidak'
            }).then((result) => {
                if (result.isConfirmed) window.location.href = url;
            });
        });

        @if ($errors->any())
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Terdapat kesalahan pada form. Silakan periksa kembali.',
                confirmButtonText: 'OK',
                confirmButtonColor: '#47b2e4'
            });
        @endif

    });
</script>
@endpush