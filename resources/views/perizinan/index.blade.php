@extends('layout.app')
<x-app-layout>

<div class="container mt-4">
    <h3 class="mb-4">Perizinan Guru</h3>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card">
        <div class="card-body table-responsive">
            <table class="table table-bordered align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>No</th>
                        <th>Guru</th>
                        <th>Jenis</th>
                        <th>Tanggal</th>
                        <th>Alasan</th>
                        <th>Surat</th>
                        <th>Status</th>
                        <th width="180">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($izins as $izin)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                {{ $izin->guru->nama_guru }} <br>
                                <small class="text-muted">{{ $izin->guru->nip }}</small>
                            </td>
                            <td>{{ ucfirst($izin->jenis_izin) }}</td>
                            <td>{{ $izin->tanggal_izin }}</td>
                            <td>{{ $izin->alasan ?? '-' }}</td>
                            <td class="text-center">
                                @if ($izin->foto_surat)
                                    <a href="{{ route('perizinan.surat', $izin->id) }}"
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
                            <td>
                                @if ($izin->status == 'menunggu')
                                    <form action="{{ route('perizinan.approve', $izin->id) }}"
                                          method="POST" class="d-inline">
                                        @csrf
                                        @method('PUT')
                                        <button class="btn btn-success btn-sm">Setujui</button>
                                    </form>

                                    <form action="{{ route('perizinan.reject', $izin->id) }}"
                                          method="POST" class="d-inline">
                                        @csrf
                                        @method('PUT')
                                        <button class="btn btn-danger btn-sm">Tolak</button>
                                    </form>
                                @else
                                    -
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center">
                                Belum ada pengajuan izin
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

</x-app-layout>
