@extends('layouts.admin')

@section('title', 'Edit Guru | Admin')

@section('content')
<div class="container-fluid p-0">

    <div class="row mb-3">
        <div class="col-12">
            <h1 class="h3 mb-0">
                <strong>Edit Guru</strong>
            </h1>
            <p class="text-muted">Edit Data Guru</p>
        </div>
    </div>

    <div class="card">
        <div class="card-body">

            <form action="{{ route('admin.guru.update', $guru->uuid) }}" method="POST" enctype="multipart/form-data" id="formEditGuru">
                @csrf
                @method('PUT')

                {{-- Nama Guru --}}
                <div class="mb-3">
                    <label class="form-label">Nama Guru</label>
                    <input
                        type="text"
                        name="nama_guru"
                        value="{{ old('nama_guru', $guru->nama_guru) }}"
                        class="form-control @error('nama_guru') is-invalid @enderror"
                    >

                    @error('nama_guru')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Email --}}
                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input
                        type="email"
                        name="email"
                        value="{{ old('email', $guru->email) }}"
                        class="form-control @error('email') is-invalid @enderror"
                    >

                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Mata Pelajaran --}}
                <div class="mb-3">
                    <label class="form-label">Mata Pelajaran</label>

                    <select
                        name="mapel_id"
                        class="form-select @error('mapel_id') is-invalid @enderror"
                    >
                        <option value="">-- Pilih Mapel --</option>

                        @foreach ($mapels as $mapel)
                            <option
                                value="{{ $mapel->id }}"
                                {{ old('mapel_id', $guru->mapel_id) == $mapel->id ? 'selected' : '' }}
                            >
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
                    <input
                        type="text"
                        name="nip"
                        value="{{ old('nip', $guru->nip) }}"
                        class="form-control @error('nip') is-invalid @enderror"
                    >

                    @error('nip')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Nomor Telepon --}}
                <div class="mb-3">
                    <label class="form-label">Nomor Telepon</label>
                    <input
                        type="text"
                        name="nomor_telepon"
                        value="{{ old('nomor_telepon', $guru->nomor_telepon) }}"
                        class="form-control @error('nomor_telepon') is-invalid @enderror"
                    >

                    @error('nomor_telepon')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Foto --}}
                <div class="mb-3">
                    <label class="form-label">Foto</label>
                    <input
                        type="file"
                        name="photo"
                        class="form-control @error('photo') is-invalid @enderror"
                    >

                    @error('photo')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror

                    @if ($guru->photo)
                        <div class="mt-2">
                            <img
                                src="{{ asset('storage/' . $guru->photo) }}"
                                width="100"
                                height="100"
                                class="rounded-2 object-fit-cover"
                            >
                        </div>
                    @endif
                </div>

                {{-- Status --}}
                <div class="mb-4">
                    <label class="form-label">Status</label>
                    <select name="is_active" class="form-select">
                        <option value="1" {{ $guru->is_active ? 'selected' : '' }}>
                            Aktif
                        </option>
                        <option value="0" {{ !$guru->is_active ? 'selected' : '' }}>
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
                        Update
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
        // Konfirmasi sebelum update
        document.getElementById('formEditGuru').addEventListener('submit', function(e) {
            e.preventDefault();
            
            Swal.fire({
                title: 'Konfirmasi',
                text: 'Apakah Anda yakin ingin mengupdate data guru ini?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Update!',
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
                text: 'Apakah Anda yakin ingin membatalkan? Perubahan tidak akan disimpan.',
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