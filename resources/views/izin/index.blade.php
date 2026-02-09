@extends('layout.app')

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Histori Izin Guru') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    {{-- Pilih Guru --}}
                    <form method="GET" action="{{ route('izin.index') }}" class="mb-4">
                        <div class="row g-2 align-items-end">
                            <div class="col-md-4">
                                <label class="form-label">Pilih Guru</label>
                                <select name="guru_id" class="form-control">
                                    <option value="">-- Pilih Guru --</option>
                                    @foreach ($gurus as $guru)
                                        <option value="{{ $guru->id }}"
                                            {{ request('guru_id') == $guru->id ? 'selected' : '' }}>
                                            {{ $guru->nama_guru }} ({{ $guru->nip }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-2">
                                <button class="btn btn-primary">Tampilkan</button>
                            </div>

                            <div class="col-md-3 ms-auto text-end">
                                <a href="{{ route('izin.create') }}" class="btn btn-success">
                                    Ajukan Izin
                                </a>
                            </div>
                        </div>
                    </form>

                    {{-- Flash Success --}}
                    @if (session('success'))
                        <div id="flash-success" data-message="{{ session('success') }}"></div>
                    @endif

                    {{-- Tabel Histori --}}
                    <table class="table mt-3">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Guru</th>
                                <th>No HP</th>
                                <th>Tanggal Izin</th>
                                <th>Jenis</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($izins as $no => $izin)
                                <tr>
                                    <td>{{ $no + 1 }}</td>
                                    <td>{{ $izin->guru->nama_guru }}</td>
                                    <td>{{ $izin->guru->nomor_telepon }}</td>
                                    <td>{{ $izin->tanggal_izin }}</td>
                                    <td>{{ ucfirst($izin->jenis_izin) }}</td>
                                    <td>
                                        @if ($izin->status == 'menunggu')
                                            <span class="badge bg-warning">Menunggu</span>
                                        @elseif ($izin->status == 'disetujui')
                                            <span class="badge bg-success">Disetujui</span>
                                        @else
                                            <span class="badge bg-danger">Ditolak</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center text-muted">
                                        Silakan pilih guru untuk melihat histori izin
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>

    {{-- SweetAlert --}}
    @push('scripts')
    <script>
        const flash = document.getElementById('flash-success');
        if (flash) {
            Swal.fire({
                icon: 'success',
                title: 'Berhasil',
                text: flash.dataset.message,
                timer: 2000,
                showConfirmButton: false
            });
        }
    </script>
    @endpush

</x-app-layout>
