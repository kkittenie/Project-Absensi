@extends('layouts.admin')

@section('title', 'Kehadiran Guru | Admin')

@push('styles')
<link rel="stylesheet" href="{{ asset('assets/admin/css/guru.css') }}">
@endpush

@section('content')

<div class="container-fluid p-0">

    <div class="page-header d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0"><strong>Kehadiran</strong> Guru</h1>
            <p class="text-muted mb-0">Data kehadiran guru hari ini</p>
        </div>
    </div>

    <div class="card">
        <div class="card-body">

            <div class="table-responsive">
                <table class="table table-striped table-hover align-middle">

                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Foto</th>
                            <th>Nama</th>
                            <th>Mapel</th>
                            <th>NIP</th>
                            <th>Jam Masuk</th>
                            <th>Jam Pulang</th>
                            <th>Catatan</th>
                            <th>Status</th>
                            <th class="text-end">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>

                        @forelse ($gurus as $guru)

                            @php
                                $hadir = $guru->kehadiran->first();
                            @endphp

                            <tr>

                                <td>{{ $loop->iteration }}</td>

                                {{-- FOTO --}}
                                <td>
                                    <img
                                        src="{{ $guru->photo ? asset('storage/'.$guru->photo) : asset('default-user.png') }}"
                                        width="40"
                                        height="40"
                                        class="rounded-circle"
                                    >
                                </td>

                                {{-- NAMA --}}
                                <td>
                                    <strong>{{ $guru->nama_guru }}</strong>
                                </td>

                                {{-- MAPEL --}}
                                <td>
                                    {{ $guru->mata_pelajaran }}
                                </td>

                                {{-- NIP --}}
                                <td>
                                    {{ $guru->nip }}
                                </td>

                                {{-- JAM MASUK --}}
                                <td>
                                    {{ $hadir?->jam_masuk ?? '-' }}
                                </td>

                                {{-- JAM PULANG --}}
                                <td>
                                    {{ $hadir?->jam_pulang ?? '-' }}
                                </td>

                                {{-- CATATAN --}}
                                <td>
                                    {{ $hadir?->catatan ?? '-' }}
                                </td>

                                {{-- STATUS --}}
                                <td>

                                    @if ($hadir)

                                        @if ($hadir->status_pulang)

                                            <span class="badge bg-warning">
                                                {{ $hadir->status_pulang }}
                                            </span>

                                        @else

                                            <span class="badge bg-success">
                                                Hadir
                                            </span>

                                        @endif

                                    @else

                                        <span class="badge bg-secondary">
                                            Belum Hadir
                                        </span>

                                    @endif

                                </td>

                                {{-- AKSI --}}
                                <td class="text-end">

                                    @if ($hadir)

                                        <a
                                            href="{{ route('admin.kehadiran.invoice', $hadir->id) }}"
                                            class="btn btn-sm btn-primary"
                                        >
                                            <i data-feather="printer"></i>
                                            Invoice
                                        </a>

                                    @else

                                        -

                                    @endif

                                </td>

                            </tr>

                        @empty

                            <tr>
                                <td colspan="10" class="text-center text-muted py-4">
                                    Belum ada data kehadiran
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