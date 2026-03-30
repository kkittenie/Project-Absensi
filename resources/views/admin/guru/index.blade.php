@extends('layouts.admin')

@section('title', 'Manajemen Guru | Admin')

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/admin/css/guru.css') }}">
@endpush

@section('content')

    <div class="container-fluid p-0">

        <div class="page-header d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h3 mb-0"><strong>Manajemen</strong> Guru</h1>
                <p class="text-muted mb-0">Daftar akun guru</p>
            </div>
            <a href="{{ route('admin.guru.create') }}" class="btn btn-primary">
                <i data-feather="plus"></i> Tambah Guru
            </a>
        </div>

        {{-- Tabs --}}
        <ul class="nav nav-tabs mb-3">
            <li class="nav-item">
                <a class="nav-link {{ request('status', 'active') === 'active' ? 'active' : '' }}"
                    href="{{ route('admin.guru.index', ['status' => 'active']) }}">
                    Guru Aktif
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request('status') === 'inactive' ? 'active' : '' }}"
                    href="{{ route('admin.guru.index', ['status' => 'inactive']) }}">
                    Guru Tidak Aktif
                </a>
            </li>
        </ul>

        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped align-middle">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Foto</th>
                                <th>Nama</th>
                                <th>Email</th>
                                <th>Mapel</th>
                                <th>NIP</th>
                                <th>Status</th>
                                <th class="text-end">Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse ($gurus as $guru)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>

                                    <td>
                                        <img src="{{ $guru->photo ? asset('storage/' . $guru->photo) : asset('assets/admin/img/avatars/default.jpg') }}"
                                            width="40" height="40" class="rounded-2 object-fit-cover">
                                    </td>

                                    <td>{{ $guru->nama_guru }}</td>
                                    <td>{{ $guru->email ?? '-' }}</td>
                                    <td>{{ $guru->mapel->nama_mapel ?? '-' }}</td>
                                    <td>{{ $guru->nip }}</td>

                                    <td>
                                        @if ($guru->is_active)
                                            <span class="badge bg-success">Aktif</span>
                                        @else
                                            <span class="badge bg-danger">Tidak Aktif</span>
                                        @endif
                                    </td>

                                    <td class="text-end">
                                        @if ($guru->is_active)
                                            <a href="{{ route('admin.guru.edit', $guru->uuid) }}" class="btn btn-sm btn-warning">
                                                <i data-feather="edit"></i>
                                            </a>

                                            <form action="{{ route('admin.guru.reset-password', $guru->uuid) }}" method="POST"
                                                class="d-inline form-reset-password">
                                                @csrf
                                                @method('PUT')
                                                <button type="button" class="btn btn-sm btn-info btn-reset-password">
                                                    <i data-feather="key"></i>
                                                </button>
                                            </form>

                                            <form action="{{ route('admin.guru.deactivate', $guru->uuid) }}" method="POST"
                                                class="d-inline form-deactivate">
                                                @csrf
                                                @method('PUT')
                                                <button type="button" class="btn btn-sm btn-danger btn-deactivate">
                                                    <i data-feather="user-x"></i>
                                                </button>
                                            </form>
                                        @else
                                            <form action="{{ route('admin.guru.remove', $guru->uuid) }}" method="POST"
                                                class="d-inline form-delete">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="btn btn-sm btn-outline-danger btn-delete">
                                                    <i data-feather="trash-2"></i>
                                                </button>
                                            </form>
                                            <form action="{{ route('admin.guru.activate', $guru->uuid) }}" method="POST"
                                                class="d-inline form-activate">
                                                @csrf
                                                @method('PUT')
                                                <button type="button" class="btn btn-sm btn-success btn-activate">
                                                    <i data-feather="user-check"></i>
                                                </button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center text-muted py-4">
                                        Data guru tidak ditemukan
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>

@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {

            @if (session('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: '{{ session('success') }}',
                    showConfirmButton: false,
                    timer: 2000,
                    timerProgressBar: true,
                    confirmButtonColor: '#47b2e4'
                });
            @endif

            document.querySelectorAll('.btn-reset-password').forEach(button => {
                button.addEventListener('click', function () {
                    const form = this.closest('.form-reset-password');
                    Swal.fire({
                        title: 'Reset Password?',
                        text: 'Password akan direset ke NIP guru ini.',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#17a2b8',
                        cancelButtonColor: '#6c757d',
                        confirmButtonText: 'Ya, Reset!',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) form.submit();
                    });
                });
            });

            document.querySelectorAll('.btn-deactivate').forEach(button => {
                button.addEventListener('click', function () {
                    const form = this.closest('.form-deactivate');
                    Swal.fire({
                        title: 'Konfirmasi',
                        text: 'Apakah Anda yakin ingin menonaktifkan guru ini?',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#dc3545',
                        cancelButtonColor: '#6c757d',
                        confirmButtonText: 'Ya, Nonaktifkan!',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) form.submit();
                    });
                });
            });

            document.querySelectorAll('.btn-delete').forEach(button => {
                button.addEventListener('click', function () {
                    const form = this.closest('.form-delete');
                    Swal.fire({
                        title: 'Konfirmasi Hapus',
                        text: 'Data yang dihapus tidak dapat dikembalikan. Yakin ingin melanjutkan?',
                        icon: 'error',
                        showCancelButton: true,
                        confirmButtonColor: '#dc3545',
                        cancelButtonColor: '#6c757d',
                        confirmButtonText: 'Ya, Hapus!',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) form.submit();
                    });
                });
            });

            document.querySelectorAll('.btn-activate').forEach(button => {
                button.addEventListener('click', function () {
                    const form = this.closest('.form-activate');
                    Swal.fire({
                        title: 'Konfirmasi',
                        text: 'Apakah Anda yakin ingin mengaktifkan kembali guru ini?',
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonColor: '#28a745',
                        cancelButtonColor: '#6c757d',
                        confirmButtonText: 'Ya, Aktifkan!',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) form.submit();
                    });
                });
            });

        });
    </script>
@endpush