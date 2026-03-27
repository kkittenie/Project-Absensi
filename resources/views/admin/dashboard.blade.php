@extends('layouts.admin')

@section('title', 'Dashboard | Admin')

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/admin/css/dashboard.css') }}">
@endpush

@section('content')

    {{-- Page Header --}}
    <div class="page-header row mb-4">
        <div class="col-12">
            <h1 class="h3 mb-0"><strong>Dashboard</strong> Admin</h1>
            <p class="text-muted">Ringkasan data sistem absensi hari ini</p>
        </div>
    </div>

    {{-- Statistic Cards --}}
    <div class="row">

        {{-- Total Guru --}}
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card stat-card">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <h5 class="card-title">Total Guru</h5>
                        <div class="stat-icon">
                            <i data-feather="users"></i>
                        </div>
                    </div>
                    <div class="stat-number">{{ $totalGuru }}</div>
                    <p class="stat-desc">
                        @if($totalGuruChange >= 0)
                            <span class="text-success">+{{ $totalGuruChange }}</span>
                        @else
                            <span class="text-danger">{{ $totalGuruChange }}</span>
                        @endif
                        dari bulan lalu
                    </p>
                </div>
            </div>
        </div>

        {{-- Hadir Hari Ini --}}
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card stat-card card-hadir">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <h5 class="card-title">Hadir Hari Ini</h5>
                        <div class="stat-icon">
                            <i data-feather="check-circle"></i>
                        </div>
                    </div>
                    <div class="stat-number">{{ $hadirHariIni }}</div>
                    <p class="stat-desc">
                        <span class="text-success">{{ $persenKehadiran }}%</span> tingkat kehadiran
                    </p>
                </div>
            </div>
        </div>

        {{-- Izin --}}
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card stat-card card-izin">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <h5 class="card-title">Izin</h5>
                        <div class="stat-icon">
                            <i data-feather="alert-circle"></i>
                        </div>
                    </div>
                    <div class="stat-number">{{ $izinHariIni }}</div>
                    <p class="stat-desc">Pengajuan izin aktif</p>
                </div>
            </div>
        </div>

        {{-- Alpha --}}
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card stat-card card-alpha">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <h5 class="card-title">Alpha</h5>
                        <div class="stat-icon">
                            <i data-feather="x-circle"></i>
                        </div>
                    </div>
                    <div class="stat-number">{{ $alphaHariIni }}</div>
                    <p class="stat-desc">Tidak hadir tanpa keterangan</p>
                </div>
            </div>
        </div>

    </div>

    {{-- Charts & Recent Attendance --}}
    <div class="row">

        {{-- Attendance Chart --}}
        <div class="col-xl-8 col-lg-7 mb-4">
            <div class="card chart-card flex-fill">
                <div class="card-header">
                    <div class="header-left">
                        <div class="header-icon">
                            <i data-feather="bar-chart-2"></i>
                        </div>
                        <h5 class="card-title">Statistik Kehadiran (5 Hari Terakhir)</h5>
                    </div>
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
                    <div class="d-flex align-items-center gap-2">
                        <div class="header-icon" style="width:36px;height:36px;border-radius:8px;background:linear-gradient(135deg,#47b2e4,#37517e);display:flex;align-items:center;justify-content:center;">
                            <i data-feather="clock" style="width:18px;height:18px;stroke:white;"></i>
                        </div>
                        <h5 class="card-title">Absensi Terbaru</h5>
                    </div>
                </div>
                <div class="card-body p-0">
                    <ul class="list-group list-group-flush attendance-list px-3">
                        @forelse($recentAbsensi as $absensi)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <div>
                                    <strong>{{ $absensi->guru->nama_guru ?? '-' }}</strong><br>
                                 <small class="text-muted">
    {{ optional($absensi->tanggal)->format('d M Y, H:i') ?? '-' }}
</small>
                                </div>
                                @if($absensi->status == 'hadir')
                                    <span class="badge bg-success">Hadir</span>
                                @elseif($absensi->status == 'izin')
                                    <span class="badge bg-warning">Izin</span>
                                @else
                                    <span class="badge bg-danger">Alpha</span>
                                @endif
                            </li>
                        @empty
                            <li class="list-group-item text-center text-muted py-3">
                                Belum ada data absensi
                            </li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>

    </div>

@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {

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

            @if ($errors->any())
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal!',
                    html: '<ul class="text-start mb-0" style="list-style-position: inside;">' +
                        @foreach ($errors->all() as $error)
                            '<li>{{ $error }}</li>' +
                        @endforeach
                        '</ul>',
                    confirmButtonText: 'OK',
                    confirmButtonColor: '#47b2e4'
                });
            @endif

            // Chart.js - Statistik Kehadiran
            if (window.Chart) {
                const ctx = document.getElementById("attendanceChart");
                new Chart(ctx, {
                    type: "line",
                    data: {
                        labels: @json($chartLabels),
                        datasets: [
                            {
                                label: "Hadir",
                                data: @json($chartHadir),
                                borderColor: "#47b2e4",
                                backgroundColor: "rgba(71, 178, 228, 0.1)",
                                borderWidth: 3,
                                fill: true,
                                tension: 0.4,
                                pointBackgroundColor: "#47b2e4",
                                pointBorderColor: "#fff",
                                pointBorderWidth: 2,
                                pointRadius: 5,
                            },
                            {
                                label: "Izin",
                                data: @json($chartIzin),
                                borderColor: "#ffc107",
                                backgroundColor: "rgba(255, 193, 7, 0.1)",
                                borderWidth: 3,
                                fill: true,
                                tension: 0.4,
                                pointBackgroundColor: "#ffc107",
                                pointBorderColor: "#fff",
                                pointBorderWidth: 2,
                                pointRadius: 5,
                            },
                            {
                                label: "Alpha",
                                data: @json($chartAlpha),
                                borderColor: "#dc3545",
                                backgroundColor: "rgba(220, 53, 69, 0.08)",
                                borderWidth: 3,
                                fill: true,
                                tension: 0.4,
                                pointBackgroundColor: "#dc3545",
                                pointBorderColor: "#fff",
                                pointBorderWidth: 2,
                                pointRadius: 5,
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                position: 'top',
                                labels: {
                                    font: {
                                        family: 'Jost',
                                        size: 13,
                                        weight: '500'
                                    },
                                    usePointStyle: true,
                                    pointStyleWidth: 10,
                                    padding: 20,
                                }
                            },
                            tooltip: {
                                backgroundColor: '#37517e',
                                titleFont: { family: 'Jost', size: 13 },
                                bodyFont: { family: 'Open Sans', size: 12 },
                                padding: 12,
                                cornerRadius: 10,
                            }
                        },
                        scales: {
                            x: {
                                grid: {
                                    display: false,
                                },
                                ticks: {
                                    font: { family: 'Open Sans', size: 12 },
                                    color: '#6c757d'
                                }
                            },
                            y: {
                                beginAtZero: true,
                                grid: {
                                    color: 'rgba(0,0,0,0.05)',
                                    drawBorder: false,
                                },
                                ticks: {
                                    font: { family: 'Open Sans', size: 12 },
                                    color: '#6c757d',
                                    stepSize: 5
                                }
                            }
                        }
                    }
                });
            }
        });
    </script>
@endpush