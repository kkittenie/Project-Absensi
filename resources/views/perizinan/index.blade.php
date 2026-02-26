@extends('layouts.admin')

@section('title', 'Perizinan Guru | Admin')

@section('content')

@if(session('success'))
    <x-alert type="success">
        {{ session('success') }}
    </x-alert>
@endif

<div class="container-fluid p-0">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h1 class="h3 mb-0">
                <strong>Perizinan</strong> Guru
            </h1>
            <p class="text-muted">
                Daftar pengajuan izin guru
            </p>
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
                                        <span class="text-danger fst-italic">
                                            Guru tidak ditemukan
                                        </span>
                                    @endif
                                </td>
                                <td>{{ ucfirst($izin->jenis_izin) }}</td>
                                <td>{{ $izin->tanggal_izin }}</td>
                                <td>{{ $izin->alasan ?? '-' }}</td>
                                <td class="text-center">
                                    @if ($izin->foto_surat)
                                        <a href="{{ route('admin.perizinan.surat', $izin->id) }}"
                                           class="btn btn-sm btn-info">
                                            Lihat
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
                                              method="POST" class="d-inline">
                                            @csrf
                                            @method('PUT')
                                            <button class="btn btn-sm btn-success">Setujui</button>
                                        </form>

                                        <form action="{{ route('admin.perizinan.reject', $izin->id) }}"
                                              method="POST" class="d-inline">
                                            @csrf
                                            @method('PUT')
                                            <button class="btn btn-sm btn-danger">Tolak</button>
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
