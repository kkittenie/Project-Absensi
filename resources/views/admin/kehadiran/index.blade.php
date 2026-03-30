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
                <p class="text-muted mb-0">Data kehadiran guru per bulan</p>
            </div>
            <button onclick="cetakKehadiran()" class="btn btn-outline-primary">
                <i data-feather="printer" style="width:16px;height:16px;"></i> Cetak
            </button>
        </div>

        {{-- Filter --}}
        <div class="card mb-4">
            <div class="card-body">
                <form method="GET" action="{{ route('admin.kehadiran.index') }}" class="row align-items-end g-3">
                    <div class="col-md-3">
                        <label class="form-label">Bulan</label>
                        <select name="bulan" class="form-select">
                            @foreach(range(1, 12) as $m)
                                <option value="{{ $m }}" {{ $bulan == $m ? 'selected' : '' }}>
                                    {{ \Carbon\Carbon::create()->month($m)->locale('id')->isoFormat('MMMM') }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Tahun</label>
                        <select name="tahun" class="form-select">
                            @foreach(range(date('Y') - 2, date('Y')) as $y)
                                <option value="{{ $y }}" {{ $tahun == $y ? 'selected' : '' }}>{{ $y }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Nama Guru</label>
                        <input type="text" name="nama" class="form-control" placeholder="Cari nama guru..."
                            value="{{ $nama ?? '' }}">
                    </div>
                    <div class="col-md-3 d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i data-feather="filter" style="width:16px;height:16px;"></i> Filter
                        </button>
                        <a href="{{ route('admin.kehadiran.index') }}" class="btn btn-secondary">Reset</a>
                    </div>
                </form>
            </div>
        </div>

        {{-- Tab --}}
        <ul class="nav nav-tabs mb-0" id="kehadiranTab">
            <li class="nav-item">
                <button class="nav-link active d-flex align-items-center gap-2" id="tab-masuk" onclick="switchTab('masuk')">
                    <i data-feather="log-in" style="width:15px;height:15px;"></i> Absen Masuk
                    <span class="badge bg-success ms-1">{{ $absenMasuk->count() }}</span>
                </button>
            </li>
            <li class="nav-item">
                <button class="nav-link d-flex align-items-center gap-2" id="tab-pulang" onclick="switchTab('pulang')">
                    <i data-feather="log-out" style="width:15px;height:15px;"></i> Absen Pulang
                    <span class="badge bg-danger ms-1">{{ $absenPulang->count() }}</span>
                </button>
            </li>
        </ul>

        {{-- Data Absen Masuk --}}
        <div class="card border-top-0 rounded-top-0" id="panel-masuk">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover align-middle">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Foto</th>
                                <th>Nama</th>
                                <th>Mapel</th>
                                <th>Tanggal</th>
                                <th>Jam Masuk</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($absenMasuk as $absen)
                                @php
                                    $tanggal = \Carbon\Carbon::parse($absen->tanggal)->toDateString();
                                    $key = $absen->guru_id . '_' . $tanggal;
                                    $absensi = $absensiMap[$key] ?? null;
                                    $dataIzin = $izins[$key] ?? null;
                                @endphp
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        @if($absensi?->photo)
                                            <img src="{{ asset('storage/' . $absensi->photo) }}" width="45" height="45"
                                                class="rounded-2 object-fit-cover" style="cursor:pointer"
                                                onclick="lihatFoto('{{ asset('storage/' . $absensi->photo) }}', 'Foto Absen Masuk - {{ $absen->guru->nama_guru }}')"
                                                title="Klik untuk perbesar">
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        <strong>{{ $absen->guru->nama_guru }}</strong><br>
                                        <small class="text-muted">{{ $absen->guru->nip }}</small>
                                    </td>
                                    <td>{{ $absen->guru->mapel->nama_mapel ?? '-' }}</td>
                                    <td>{{ \Carbon\Carbon::parse($absen->tanggal)->locale('id')->isoFormat('dddd, D MMM Y') }}
                                    </td>
                                    <td>{{ $absen->jam_masuk ? \Carbon\Carbon::parse($absen->jam_masuk)->format('H:i') : '-' }}
                                    </td>
                                    <td>
                                        @if($dataIzin)
                                            <span class="badge bg-info text-dark">{{ ucfirst($dataIzin->jenis_izin) }}</span>
                                        @elseif($absensi?->status === 'tepat_waktu')
                                            <span class="badge bg-success">Tepat Waktu</span>
                                        @elseif($absensi?->status === 'terlambat')
                                            <span class="badge bg-warning text-dark">Terlambat</span>
                                        @elseif($absensi?->status === 'alpha')
                                            <span class="badge bg-danger">Alpha</span>
                                        @else
                                            <span class="badge bg-secondary">-</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center text-muted py-4">
                                        Belum ada data absen masuk
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- Data Absen Pulang --}}
        <div class="card border-top-0 rounded-top-0" id="panel-pulang" style="display:none;">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover align-middle">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Foto</th>
                                <th>Nama</th>
                                <th>Mapel</th>
                                <th>Tanggal</th>
                                <th>Jam Pulang</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($absenPulang as $absen)
                             @php
    $tanggal = \Carbon\Carbon::parse($absen->tanggal)->toDateString();
    $key = $absen->guru_id . '_' . $tanggal;

    $absensi = $absensiMap[$key] ?? null;
    $dataIzin = $izins[$key] ?? null;

    $jamPulang = null;

if ($absen->jam_pulang) {
    $jp = \Carbon\Carbon::parse($absen->jam_pulang);

    if ($jp->format('H:i') >= '12:00') {
        $jamPulang = $jp;
    }
}

    $mulaiPulang = \Carbon\Carbon::parse($tanggal . ' ' . ($absen->jam_mulai_pulang ?? '13:00'));
$akhirPulang = \Carbon\Carbon::parse($tanggal . ' ' . ($absen->jam_akhir_pulang ?? '15:00'));

    $pulangCepat = $jamPulang && $jamPulang->lt($mulaiPulang);
    $lembur      = $jamPulang && $jamPulang->gt($akhirPulang);

    $selisihCepat = $pulangCepat
        ? $jamPulang->diffInMinutes($mulaiPulang)
        : 0;

    $lemburMenit = $lembur
        ? $akhirPulang->diffInMinutes($jamPulang)
        : 0;
@endphp
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        @if($absensi?->photo_pulang)
                                            <img src="{{ asset('storage/' . $absensi->photo_pulang) }}" width="45" height="45"
                                                class="rounded-2 object-fit-cover" style="cursor:pointer"
                                                onclick="lihatFoto('{{ asset('storage/' . $absensi->photo_pulang) }}', 'Foto Absen Pulang - {{ $absen->guru->nama_guru }}')"
                                                title="Klik untuk perbesar">
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td><strong>{{ $absen->guru->nama_guru }}</strong></td>
                                    <td>{{ $absen->guru->mapel->nama_mapel ?? '-' }}</td>
                                    <td>{{ \Carbon\Carbon::parse($absen->tanggal)->locale('id')->isoFormat('dddd, D MMM Y') }}
                                    </td>
                                    <td>{{ \Carbon\Carbon::parse($absen->jam_pulang)->format('H:i') }}</td>
                                    <td>
    @if($dataIzin)
        <span class="badge bg-info text-dark">{{ ucfirst($dataIzin->jenis_izin) }}</span>

    @elseif($absensi?->status_pulang === 'pulang_cepat')
    <span class="badge bg-danger">
        Pulang Cepat ({{ $absensi->selisih_pulang_cepat ?? 0 }} mnt)
    </span>

    @elseif($absensi?->status_pulang === 'lembur')
        <span class="badge bg-info text-dark">
            Lembur {{ $absensi->lembur_menit ?? 0 }} menit
        </span>

    @elseif($absensi?->status_pulang === 'tepat_waktu')
        <span class="badge bg-success">Tepat Waktu</span>

    @else
        <span class="badge bg-secondary">-</span>
    @endif
</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center text-muted py-4">
                                        Belum ada data absen pulang
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

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        @if (session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: "{{ session('success') }}",
                showConfirmButton: false,
                timer: 2000,
                timerProgressBar: true,
            });
        @endif

            function switchTab(tab) {
                document.getElementById('panel-masuk').style.display = tab === 'masuk' ? 'block' : 'none';
                document.getElementById('panel-pulang').style.display = tab === 'pulang' ? 'block' : 'none';
                document.getElementById('tab-masuk').classList.toggle('active', tab === 'masuk');
                document.getElementById('tab-pulang').classList.toggle('active', tab === 'pulang');
            }

        function cetakKehadiran() {
            const bulan = document.querySelector('select[name=bulan]').value;
            const tahun = document.querySelector('select[name=tahun]').value;
            const aktifTab = document.getElementById('tab-masuk').classList.contains('active') ? 'masuk' : 'pulang';
            const url = `{{ route('admin.kehadiran.cetak') }}?bulan=${bulan}&tahun=${tahun}&tab=${aktifTab}`;
            const win = window.open(url, '_blank');
            win.onload = () => win.print();
        }

        function lihatFoto(url, judul) {
            Swal.fire({
                title: judul,
                imageUrl: url,
                imageAlt: judul,
                imageWidth: '100%',
                showConfirmButton: false,
                showCloseButton: true,
            });
        }
    </script>
@endpush