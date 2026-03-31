@extends('layouts.landing')

@section('content')

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @if(session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Berhasil',
                text: "{{ session('success') }}",
                timer: 2500,
                showConfirmButton: false
            });
        </script>
    @endif

    @if(session('error'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Gagal',
                text: "{{ session('error') }}"
            });
        </script>
    @endif

    @php
        $canAbsen = auth()->guard('guru')->check();
    @endphp

    <section class="section dark-background" style="padding-top:120px">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-4 text-center">

                    <h3 class="mb-3">📸 Form Absensi</h3>

                    @if($canAbsen)
                        <div class="mb-3">
                            @if($sudahAbsenMasuk && $kehadiranHariIni)
                                @php
                                    $jamMasuk = \Carbon\Carbon::parse($kehadiranHariIni->jam_masuk);
                                    $batasTerlambat = \Carbon\Carbon::parse(now()->toDateString() . ' ' . $jam->batas_terlambat);

                                    $terlambat = $jamMasuk->gt($batasTerlambat);
                                $selisih = $terlambat ? (int) $jamMasuk->diffInMinutes($batasTerlambat, true) : 0;                                @endphp

                                <div class="alert {{ $terlambat ? 'alert-warning' : 'alert-success' }} py-2">
                                    ✅ Absen Masuk:
                                    <strong>{{ $jamMasuk->format('H:i') }}</strong>

                                    @if($terlambat)
                                        <br><small class="text-danger">⚠️ Terlambat {{ $selisih }} menit</small>
                                    @endif
                                </div>
                            @endif
                            @if($sudahAbsenPulang && $kehadiranHariIni)
                                @php
                                    $jamPulang = \Carbon\Carbon::parse($kehadiranHariIni->jam_pulang);

                                    $batasNormal = \Carbon\Carbon::parse(now()->toDateString() . ' ' . $jam->mulai_tap_out);
                                    $batasAkhir = \Carbon\Carbon::parse(now()->toDateString() . ' ' . $jam->akhir_tap_out);

                                    $pulangCepat = $jamPulang->lt($batasNormal);
                                    $lembur = $jamPulang->gt($batasAkhir);

                                    $selisih = $pulangCepat ? (int) abs($jamPulang->diffInMinutes($batasNormal)) : 0;
                                    $lemburMenit = $lembur ? (int) abs($jamPulang->diffInMinutes($batasAkhir)) : 0;
                                @endphp

                                <div class="alert 
                                            {{ $pulangCepat ? 'alert-warning' : ($lembur ? 'alert-info' : 'alert-success') }} 
                                            py-2">

                                    🏠 Absen Pulang: <strong>{{ $jamPulang->format('H:i') }}</strong>

                                    @if($pulangCepat)
                                        <br><small class="text-danger">⚠️ Pulang cepat {{ $selisih }} menit lebih awal</small>

                                    @elseif($lembur)
                                        <br><small class="text-info">⏰ Lembur {{ $lemburMenit }} menit</small>
                                    @endif

                                </div>
                            @endif
                        </div>
                    @endif

                    <div class="card shadow p-3">

                        <video id="video" class="w-100 rounded mirror" autoplay muted playsinline></video>
                        <canvas id="canvas" hidden></canvas>

                        @if(!$canAbsen && !auth()->guard('web')->check())
                            <script>
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Gagal',
                                    text: 'Hanya guru yang bisa melakukan absensi!'
                                });
                            </script>
                        @endif

                        @if($canAbsen)
                            @if($isLibur)
                                <div class="alert alert-secondary mt-3">
                                    🏖️ Hari ini adalah hari libur, tidak perlu absen
                                </div>

                            @elseif($absenHariIni?->status === 'izin')
                                <div class="alert alert-info mt-3">
                                    📋 Kamu sudah mengajukan izin hari ini
                                </div>

                            @elseif($absenHariIni?->status === 'alpha')
                                <div class="alert alert-danger mt-3">
                                    ❌ Kamu tercatat <strong>Alpha</strong> hari ini
                                </div>

                            @elseif($sudahAbsenPulang)
                                <div class="alert alert-success mt-3">
                                    🎉 Absensi hari ini sudah lengkap!
                                </div>

                            @else
                                <button type="button" id="snap" class="btn w-100 mt-3 btn-primary">
                                    📍 Absen Masuk
                                </button>
                            @endif
                        @else
                            <button class="btn btn-primary w-100 mt-3" disabled>
                                📍 Absen Sekarang
                            </button>
                        @endif

                    </div>

                    <form id="absenForm" method="POST" action="{{ route('guru.absensi.store') }}">
                        @csrf
                        <input type="hidden" name="photo_base64" id="photo">
                        <input type="hidden" name="latitude" id="latitude">
                        <input type="hidden" name="longitude" id="longitude">
                        <input type="hidden" name="mode" id="modeInput">
                    </form>


                </div>
            </div>
        </div>
    </section>

    <style>
        .mirror {
            transform: scaleX(-1);
        }
    </style>

    <script>
        const SCHOOL_LAT = -6.759614;
        const SCHOOL_LNG = 108.4719739;
        const MAX_RADIUS = 40000;

        const JAM_MASUK_MULAI = "{{ $jam->mulai_tap_in }}";
        const JAM_MASUK_SELESAI = "{{ $jam->akhir_tap_in }}";
        const JAM_PULANG_MULAI = "{{ $jam->mulai_tap_out }}";
        const JAM_PULANG_SELESAI = "{{ $jam->akhir_tap_out }}";
        const IS_LIBUR = {{ $isLibur ? 'true' : 'false' }};

        const SUDAH_MASUK = {{ $sudahAbsenMasuk ? 'true' : 'false' }};
        const SUDAH_PULANG = {{ $sudahAbsenPulang ? 'true' : 'false' }};

        function getMode() {
            const jam = new Date().toTimeString().slice(0, 5);
            if (jam >= JAM_MASUK_MULAI && jam <= JAM_MASUK_SELESAI) return 'masuk';
            if (jam >= JAM_PULANG_MULAI && jam <= JAM_PULANG_SELESAI) return 'pulang';
            return 'tutup';
        }

        function updateTombol() {
            const snap = document.getElementById('snap');
            if (!snap) return;

            const mode = getMode();

            if (SUDAH_MASUK && !SUDAH_PULANG) {
                snap.disabled = false;
                snap.className = 'btn w-100 mt-3 btn-warning';
                snap.innerText = '🏠 Absen Pulang';
            } else if (!SUDAH_MASUK && mode === 'masuk') {
                snap.disabled = false;
                snap.className = 'btn w-100 mt-3 btn-primary';
                snap.innerText = '📍 Absen Masuk';
            } else if (!SUDAH_MASUK && mode === 'tutup') {
                snap.disabled = true;
                snap.className = 'btn w-100 mt-3 btn-secondary';
                snap.innerText = '🕐 Di luar jam absensi';
            } else if (!SUDAH_MASUK && mode === 'pulang') {
                snap.disabled = true;
                snap.className = 'btn w-100 mt-3 btn-secondary';
                snap.innerText = '⚠️ Belum absen masuk';
            }
        }

        updateTombol();
        setInterval(updateTombol, 60000);

        const video = document.getElementById('video');
        const canvas = document.getElementById('canvas');
        const snap = document.getElementById('snap');
        const photoInput = document.getElementById('photo');
        const latitude = document.getElementById('latitude');
        const longitude = document.getElementById('longitude');
        const modeInput = document.getElementById('modeInput');

        function hitungJarak(lat1, lon1, lat2, lon2) {
            const R = 6371000;
            const dLat = (lat2 - lat1) * Math.PI / 180;
            const dLon = (lon2 - lon1) * Math.PI / 180;
            const a =
                Math.sin(dLat / 2) ** 2 +
                Math.cos(lat1 * Math.PI / 180) *
                Math.cos(lat2 * Math.PI / 180) *
                Math.sin(dLon / 2) ** 2;
            return R * (2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a)));
        }

        if (snap) {
            let cameraActive = false;
            let sudahKonfirmasiPulangCepat = false;

            snap.addEventListener('click', async () => {
                const mode = getMode();

                if (IS_LIBUR) {
                    Swal.fire({
                        icon: 'info',
                        title: 'Hari Libur',
                        text: 'Hari ini adalah hari libur, tidak perlu absen.'
                    });
                    return;
                }

                if (!SUDAH_MASUK && mode === 'tutup') {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Di luar jam absensi',
                        text: `Masuk: ${JAM_MASUK_MULAI}–${JAM_MASUK_SELESAI} | Pulang: ${JAM_PULANG_MULAI}–${JAM_PULANG_SELESAI}`
                    });
                    return;
                }

                if (SUDAH_MASUK && !SUDAH_PULANG && !sudahKonfirmasiPulangCepat) {
                    const jamSekarang = new Date().toTimeString().slice(0, 5);

                    if (jamSekarang < JAM_PULANG_MULAI) {
                        const konfirmasi = await Swal.fire({
                            icon: 'warning',
                            title: 'Pulang Lebih Awal?',
                            text: `Jam pulang normal adalah ${JAM_PULANG_MULAI}. Kamu akan tercatat pulang cepat. Lanjutkan?`,
                            showCancelButton: true,
                            confirmButtonText: 'Ya, Lanjutkan',
                            cancelButtonText: 'Batal',
                            confirmButtonColor: '#e0a800',
                            cancelButtonColor: '#6c757d',
                        });

                        if (!konfirmasi.isConfirmed) return;
                        sudahKonfirmasiPulangCepat = true;
                    }
                }

                if (!cameraActive) {
                    try {
                        const stream = await navigator.mediaDevices.getUserMedia({ video: true });
                        video.srcObject = stream;
                        cameraActive = true;
                    } catch (e) {
                        Swal.fire({ icon: 'error', title: 'Kamera tidak bisa diakses' });
                    }
                    return;
                }

                snap.disabled = true;
                snap.innerText = 'Mengambil lokasi...';

                navigator.geolocation.getCurrentPosition(
                    function (pos) {
                        latitude.value = pos.coords.latitude;
                        longitude.value = pos.coords.longitude;

                        const jarak = hitungJarak(
                            latitude.value, longitude.value,
                            SCHOOL_LAT, SCHOOL_LNG
                        );

                        if (jarak > MAX_RADIUS) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Di luar area sekolah',
                                text: `Jarak ${Math.round(jarak)} meter`
                            });
                            resetBtn();
                            return;
                        }

                        canvas.width = video.videoWidth;
                        canvas.height = video.videoHeight;
                        canvas.getContext('2d').drawImage(video, 0, 0);
                        photoInput.value = canvas.toDataURL('image/png');

                        const modeSekarang = SUDAH_MASUK ? 'pulang' : 'masuk';
                        modeInput.value = modeSekarang;
                        const labelAbsen = modeSekarang === 'pulang' ? 'Absen Pulang' : 'Absen Masuk';

                        Swal.fire({
                            title: `Yakin ingin ${labelAbsen}?`,
                            imageUrl: photoInput.value,
                            showCancelButton: true,
                            confirmButtonText: `Ya, ${labelAbsen}`
                        }).then(result => {
                            if (result.isConfirmed) {
                                document.getElementById('absenForm').submit();
                            } else {
                                resetBtn();
                            }
                        });
                    },
                    function (error) {
                        let message = '';
                        switch (error.code) {
                            case 1: message = 'Kamu menolak izin lokasi'; break;
                            case 2: message = 'Lokasi tidak tersedia (coba pindah tempat atau mengganti jaringan)'; break;
                            case 3: message = 'Request lokasi timeout. Coba lagi nanti'; break;
                            default: message = error.message;
                        }
                        Swal.fire({ icon: 'error', title: 'Gagal ambil lokasi', text: message });
                        resetBtn();
                    }
                );
            });

            function resetBtn() {
                snap.disabled = false;
                updateTombol();
            }
        }
    </script>

@endsection