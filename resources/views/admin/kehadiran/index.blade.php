@extends('layouts.admin')

@section('content')
<div class="container">
    <h4 class="mb-3">Kehadiran Guru Hari Ini</h4>

    <div class="card">
        <div class="card-body table-responsive">
            <table class="table table-bordered align-middle">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Foto</th>
                        <th>Nama</th>
                        <th>Mapel</th>
                        <th>NIP</th>
                        <th>Jam Masuk</th>
                        <th>Jam Pulang</th>
                        <th>Catatan</th>
                        <th>Status Pulang</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($gurus as $guru)
                        @php
                            $hadir = $guru->kehadiran->first();
                        @endphp
                        <tr>
                            <td>{{ $loop->iteration }}</td>

                            {{-- FOTO --}}
                            <td>
                                <img src="{{ $guru->photo ? asset('storage/'.$guru->photo) : asset('default-user.png') }}"
                                     width="40" class="rounded-circle">
                            </td>

                            {{-- NAMA --}}
                            <td>{{ $guru->nama_guru }}</td>

                            {{-- MAPEL --}}
                            <td>{{ $guru->mata_pelajaran }}</td>

                            {{-- NIP --}}
                            <td>{{ $guru->nip }}</td>

                            {{-- JAM MASUK --}}
                            <td>{{ $hadir?->jam_masuk ?? '-' }}</td>

                            {{-- JAM PULANG --}}
                            <td>{{ $hadir?->jam_pulang ?? '-' }}</td>

                            {{-- CATATAN --}}
                            <td>{{ $hadir?->catatan ?? '-' }}</td>

                            {{-- STATUS PULANG --}}
                            <td>
                                @if ($hadir)
                                    @if ($hadir->status_pulang)
                                        <span class="badge bg-warning">{{ $hadir->status_pulang }}</span>
                                    @else
                                        <span class="badge bg-success">Hadir</span>
                                    @endif
                                @else
                                    <span class="badge bg-secondary">Belum Hadir</span>
                                @endif
                            </td>

                            {{-- AKSI --}}
                            <td>
                                {{-- Cetak Invoice --}}
                              @if ($hadir)
    <a href="{{ route('admin.kehadiran.invoice', $hadir->id) }}" class="btn btn-sm btn-primary mt-1">Cetak Invoice</a>
                                                    @endif

                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
