@extends('layouts.admin')

@section('title', 'Perizinan Guru | Admin')

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/admin/css/guru.css') }}">
@endpush

@section('content')

<div class="container-fluid p-0">

    <div class="page-header d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0"><strong>Perizinan</strong> Guru</h1>
            <p class="text-muted mb-0">Daftar pengajuan izin guru</p>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover align-middle">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Guru</th>
                            <th>Jenis</th>
                            <th>Tanggal</th>
                            <th>Alasan</th>
                            <th>Surat</th>
                            <th>Status</th>
                            <th class="text-end">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($izins as $izin)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    @if ($izin->guru)
                                        <strong>{{ $izin->guru->nama_guru }}</strong><br>
                                        <small class="text-muted">{{ $izin->guru->nip }}</small>
                                    @else
                                        <span class="text-danger fst-italic">Guru tidak ditemukan</span>
                                    @endif
                                </td>
                                <td><span class="badge bg-secondary">{{ ucfirst($izin->jenis_izin) }}</span></td>
                                <td>{{ \Carbon\Carbon::parse($izin->tanggal_izin)->format('d M Y') }}</td>
                                <td>{{ Str::limit($izin->alasan ?? '-', 40) }}</td>
                                <td class="text-center">
                                    @if ($izin->foto_surat)
                                        <a href="{{ route('admin.perizinan.surat', $izin->id) }}"
                                           class="btn btn-sm btn-info">
                                            <i data-feather="file-text"></i>
                                        </a>
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>
                                    @if ($izin->status == 'menunggu')
                                        <span class="badge bg-warning">Menunggu</span>
                                    @elseif ($izin->status == 'disetujui')
                                        <span class="badge bg-success">Disetujui</span>
                                    @else
                                        <span class="badge bg-danger">Ditolak</span>
                                    @endif
                                </td>
                                <td class="text-end">
                                    @if ($izin->status == 'menunggu')
                                        <form action="{{ route('admin.perizinan.approve', $izin->id) }}"
                                              method="POST" class="d-inline form-approve">
                                            @csrf
                                            @method('PUT')
                                            <button type="button" class="btn btn-sm btn-success btn-approve">
                                                <i data-feather="check"></i>
                                            </button>
                                        </form>

                                        <form action="{{ route('admin.perizinan.reject', $izin->id) }}"
                                              method="POST" class="d-inline form-reject">
                                            @csrf
                                            @method('PUT')
                                            <button type="button" class="btn btn-sm btn-danger btn-reject">
                                                <i data-feather="x"></i>
                                            </button>
                                        </form>
                                    @else
                                        -
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center text-muted py-4">
                                    Belum ada pengajuan izin
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
    document.addEventListener('DOMContentLoaded', function() {

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

        document.querySelectorAll('.btn-approve').forEach(button => {
            button.addEventListener('click', function() {
                const form = this.closest('.form-approve');
                Swal.fire({
                    title: 'Konfirmasi',
                    text: 'Setujui pengajuan izin ini?',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#28a745',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Ya, Setujui!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) form.submit();
                });
            });
        });

        document.querySelectorAll('.btn-reject').forEach(button => {
            button.addEventListener('click', function() {
                const form = this.closest('.form-reject');
                Swal.fire({
                    title: 'Konfirmasi',
                    text: 'Tolak pengajuan izin ini?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#dc3545',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Ya, Tolak!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) form.submit();
                });
            });
        });

    });
</script>
@endpush