@extends('layouts.admin')

@section('content')
<div class="container mt-4">
    <h4>Kehadiran Guru Hari Ini</h4>

    <table class="table table-bordered">
        <thead class="table-dark text-center">
            <tr>
                <th>No</th>
                <th class="text-start">Nama</th>
                <th>Status</th>
                <th>Masuk</th>
                <th>Pulang</th>
                <th>Aksi</th>
            </tr>
        </thead>

        <tbody>
            @foreach($gurus as $guru)
                @php
                    $today = $guru->waktus->first();

                    $masuk = $today && $today->jam_masuk
                        ? \Carbon\Carbon::parse($today->jam_masuk)
                        : null;

                    $pulang = $today && $today->jam_pulang
                        ? \Carbon\Carbon::parse($today->jam_pulang)
                        : null;

                    // aturan jam
                    $jamMasukNormal  = \Carbon\Carbon::createFromTime(7, 0);
                    $jamPulangNormal = \Carbon\Carbon::createFromTime(12, 0);
                    $jamLembur       = \Carbon\Carbon::createFromTime(12, 30);
                @endphp

                <tr class="text-center">
                    <td>{{ $loop->iteration }}</td>
                    <td class="text-start">{{ $guru->nama_guru }}</td>

                    {{-- STATUS --}}
                    <td>
                        {{-- BELUM MASUK --}}
                        @if(!$today)
                            <span class="badge bg-secondary">Belum Masuk</span>

                        {{-- SUDAH MASUK, BELUM PULANG --}}
                        @elseif($masuk && !$pulang)
                            @if($masuk->lte($jamMasukNormal))
                                <span class="badge bg-success">Tepat Waktu</span>
                            @else
                                @php
                                    $terlambatMenit = $jamMasukNormal->diffInMinutes($masuk);
                                    $jam   = intdiv($terlambatMenit, 60);
                                    $menit = $terlambatMenit % 60;
                                @endphp

                                <span class="badge bg-danger">
                                    Terlambat
                                    {{ $jam > 0 ? $jam.' jam ' : '' }}
                                    {{ $menit }} menit
                                </span>
                            @endif

                        {{-- SUDAH PULANG --}}
                        @elseif($pulang)
                            @if($pulang->lt($jamPulangNormal))
                                <span class="badge bg-warning text-dark">Pulang Cepat</span>
                            @elseif($pulang->gte($jamLembur))
                                <span class="badge bg-info">Lembur</span>
                            @else
                                <span class="badge bg-primary">Pulang Tepat</span>
                            @endif
                        @endif
                    </td>

                    {{-- JAM --}}
                    <td>{{ $masuk ? $masuk->format('H:i') : '-' }}</td>
                    <td>{{ $pulang ? $pulang->format('H:i') : '-' }}</td>

                    {{-- AKSI --}}
                    <td>
                        @if(!$today)
                            <form method="POST" action="{{ route('admin.waktu.masuk', $guru->id) }}">
                                @csrf
                                <button class="btn btn-success btn-sm">Masuk</button>
                            </form>

                        @elseif(!$pulang)
                            <form method="POST" action="{{ route('admin.waktu.pulang', $guru->id) }}">
                                @csrf
                                <button class="btn btn-danger btn-sm">Pulang</button>
                            </form>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

{{-- AUTO REFRESH SAAT GANTI HARI (00:00 WIB) --}}
<script>
    function refreshAtMidnight() {
        const now = new Date();

        const midnight = new Date();
        midnight.setHours(24, 0, 0, 0);

        const timeout = midnight.getTime() - now.getTime();

        setTimeout(function () {
            location.reload();
        }, timeout);
    }

    refreshAtMidnight();
</script>
@endsection
