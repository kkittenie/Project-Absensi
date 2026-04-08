@extends('layouts.landing')

@section('title', 'Status Izin | SiHadir Guru')

@section('content')

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @if(session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Berhasil',
                text: '{{ session('success') }}',
                timer: 2500,
                showConfirmButton: false
            });
        </script>
    @endif

    <section class="section dark-background" style="padding-top:120px">
        <div class="container">

            <div class="row justify-content-center">

                <div class="col-md-8 text-center">

                    {{-- JUDUL --}}
                    <h3 class="mb-2">📋 Status Izin</h3>
                    <p class="text-light mb-4">
                        Daftar pengajuan izin yang pernah kamu ajukan
                    </p>

                    {{-- CARD --}}
                    <div class="card shadow p-4 text-start">

                        <div class="table-responsive">
                            <table class="table align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th width="60">No</th>
                                        <th>Tanggal</th>
                                        <th>Jenis</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($izins as $izin)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $izin->tanggal_izin }}</td>
                                            <td>{{ ucfirst($izin->jenis_izin) }}</td>
                                            <td>
                                                @if ($izin->status == 'menunggu')
                                                    <span class="badge bg-warning">
                                                        Menunggu
                                                    </span>
                                                @elseif ($izin->status == 'disetujui')
                                                    <span class="badge bg-success">
                                                        Disetujui
                                                    </span>
                                                @else
                                                    <span class="badge bg-danger">
                                                        Ditolak
                                                    </span>
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center text-muted py-4">
                                                Belum ada pengajuan izin
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                    </div>
                    <div class="back-link mt-3">
                        <a href="{{ route('landing.index') }}" style="color: #fff;">
                            <i class="bi bi-arrow-left"></i> Kembali ke Beranda
                        </a>
                    </div>
                </div>

            </div>

        </div>
    </section>

@endsection