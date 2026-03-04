@extends('layouts.admin')

@section('title', 'Invoice Kehadiran')

@section('content')
<div class="container mt-4">

    <h3 class="mb-3">Rekap Kehadiran Guru</h3>

    <p>Nama Guru: <b>{{ $guru->nama_guru }}</b></p>

    @if($kehadirans->count())
        <p>Periode: 
            <b>
                {{ \Carbon\Carbon::parse($kehadirans->first()->tanggal)->format('d-m-Y') }}
                s/d
                {{ \Carbon\Carbon::parse($kehadirans->last()->tanggal)->format('d-m-Y') }}
            </b>
        </p>
    @else
        <p>Periode: -</p>
    @endif

    <table class="table table-bordered">
        <thead class="table-dark text-center">
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Jam Masuk</th>
                <th>Jam Pulang</th>
                <th>Lembur (menit)</th>
            </tr>
        </thead>
        <tbody>
            @forelse($kehadirans as $index => $k)
                <tr class="text-center">
                    <td>{{ $index + 1 }}</td>
                    <td>{{ \Carbon\Carbon::parse($k->tanggal)->format('d-m-Y') }}</td>
                    <td>{{ $k->jam_masuk ?? '-' }}</td>
                    <td>{{ $k->jam_pulang ?? '-' }}</td>
                    <td>{{ $k->lembur_menit ?? 0 }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center">Tidak ada data kehadiran</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{-- Tombol Cetak --}}
    <button onclick="window.print()" class="btn btn-primary mt-3">
        Cetak Invoice
    </button>

</div>

<style>
@media print {
    .btn { display: none; }
}
</style>
@endsection
