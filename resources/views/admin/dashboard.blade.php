@extends('layouts.admin')

@section('title', 'Dashboard | Admin')

@section('content')

    @if ($errors->any())
        <x-alert type="danger" title="Gagal!">
            <ul class="mb-0 ps-3">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </x-alert>
    @endif

    @if (session('success'))
        <x-alert type="success">
            {{ session('success') }}
        </x-alert>
    @endif

    {{-- Page Header --}}
    <div class="row mb-3">
        <div class="col-12">
            <h1 class="h3 mb-0">
                <strong>Dashboard</strong> Admin
            </h1>
            <p class="text-muted">
                Ringkasan data sistem absensi hari ini
            </p>
        </div>
    </div>

    {{-- Statistic Cards --}}
    <div class="row">

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col mt-0">
                            <h5 class="card-title">Total Siswa</h5>
                        </div>
                        <div class="col-auto">
                            <i class="align-middle" data-feather="users"></i>
                        </div>
                    </div>
                    <h1 class="mt-1 mb-3">320</h1>
                    <div class="mb-0 text-muted">
                        <span class="text-success">+5</span> dari bulan lalu
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col mt-0">
                            <h5 class="card-title">Hadir Hari Ini</h5>
                        </div>
                        <div class="col-auto">
                            <i class="align-middle" data-feather="check-circle"></i>
                        </div>
                    </div>
                    <h1 class="mt-1 mb-3">295</h1>
                    <div class="mb-0 text-muted">
                        <span class="text-success">92%</span> tingkat kehadiran
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col mt-0">
                            <h5 class="card-title">Izin</h5>
                        </div>
                        <div class="col-auto">
                            <i class="align-middle" data-feather="alert-circle"></i>
                        </div>
                    </div>
                    <h1 class="mt-1 mb-3">18</h1>
                    <div class="mb-0 text-muted">
                        Pengajuan izin aktif
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col mt-0">
                            <h5 class="card-title">Alpha</h5>
                        </div>
                        <div class="col-auto">
                            <i class="align-middle" data-feather="x-circle"></i>
                        </div>
                    </div>
                    <h1 class="mt-1 mb-3">7</h1>
                    <div class="mb-0 text-muted">
                        Tidak hadir tanpa keterangan
                    </div>
                </div>
            </div>
        </div>

    </div>

    {{-- Charts & Table --}}
    <div class="row">

        {{-- Attendance Chart --}}
        <div class="col-xl-8 col-lg-7 mb-4">
            <div class="card flex-fill">
                <div class="card-header">
                    <h5 class="card-title mb-0">Statistik Kehadiran</h5>
                </div>
                <div class="card-body">
                    <canvas id="attendanceChart"></canvas>
                </div>
            </div>
        </div>

        {{-- Recent Attendance --}}
        <div class="col-xl-4 col-lg-5 mb-4">
            <div class="card flex-fill">
                <div class="card-header">
                    <h5 class="card-title mb-0">Absensi Terbaru</h5>
                </div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between">
                            <span>XI RPL 1</span>
                            <span class="badge bg-success">Hadir</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between">
                            <span>XI RPL 2</span>
                            <span class="badge bg-warning">Izin</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between">
                            <span>X TKJ 1</span>
                            <span class="badge bg-danger">Alpha</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

    </div>

@endsection

@push('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            if (window.Chart) {
                const ctx = document.getElementById("attendanceChart");
                new Chart(ctx, {
                    type: "line",
                    data: {
                        labels: ["Sen", "Sel", "Rab", "Kam", "Jum"],
                        datasets: [{
                            label: "Hadir",
                            data: [280, 290, 300, 295, 305],
                            borderWidth: 2,
                            fill: false
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false
                    }
                });
            }
        });
    </script>
@endpush
