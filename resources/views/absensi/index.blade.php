@extends('layouts.landing')

@section('content')

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    {{-- SWEET ALERT SESSION --}}
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

    @if(session('error'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Gagal',
                text: '{{ session('error') }}'
            });
        </script>
    @endif

    <section class="section dark-background" style="padding-top:120px">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-4 text-center">

                    <h3 class="mb-3">📸 Form Absensi</h3>

                    <div class="card shadow p-3">

                        <video id="video" class="w-100 rounded mirror" autoplay muted playsinline></video>
                        <canvas id="canvas" hidden></canvas>

                        <button type="button" id="snap" class="btn btn-primary w-100 mt-3">
                            Aktifkan Kamera
                        </button>


                    </div>

                    <form id="absenForm" method="POST" action="{{ route('absensi.store') }}">
                        @csrf
                        <input type="hidden" name="photo_base64" id="photo">
                        <input type="hidden" name="latitude" id="latitude">
                        <input type="hidden" name="longitude" id="longitude">
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
        const SCHOOL_LAT = -6.7340;
        const SCHOOL_LNG = 108.5367;
        const MAX_RADIUS = 200;
        const ABSEN_MULAI = "06:00";
        const ABSEN_SELESAI = "21:00";

        const video = document.getElementById('video');
        const canvas = document.getElementById('canvas');
        const snap = document.getElementById('snap');
        const photoInput = document.getElementById('photo');
        const latitude = document.getElementById('latitude');
        const longitude = document.getElementById('longitude');

        let cameraActive = false; // ✅ PINDAH KE SINI

        function cekJamAbsen() {
            const jam = new Date().toTimeString().slice(0, 5);
            return jam >= ABSEN_MULAI && jam <= ABSEN_SELESAI;
        }

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

        snap.addEventListener('click', async () => {

            // =====================
            // AKTIFKAN KAMERA
            // =====================
            if (!cameraActive) {
                try {
                    const stream = await navigator.mediaDevices.getUserMedia({ video: true });
                    video.srcObject = stream;

                    cameraActive = true;
                    snap.innerText = 'Absen Sekarang';
                    snap.classList.remove('btn-success');
                    snap.classList.add('btn-primary');
                } catch (e) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Kamera tidak bisa diakses'
                    });
                }
                return;
            }

            // =====================
            // PROSES ABSENSI
            // =====================
            if (!cekJamAbsen()) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Di luar jam absensi',
                    text: `${ABSEN_MULAI} - ${ABSEN_SELESAI}`
                });
                return;
            }

            snap.disabled = true;
            snap.innerText = 'Mengambil lokasi...';

            navigator.geolocation.getCurrentPosition(
                function (pos) {

                    latitude.value = pos.coords.latitude;
                    longitude.value = pos.coords.longitude;

                    const jarak = hitungJarak(
                        latitude.value,
                        longitude.value,
                        SCHOOL_LAT,
                        SCHOOL_LNG
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

                    Swal.fire({
                        title: 'Yakin ingin absen?',
                        imageUrl: photoInput.value,
                        showCancelButton: true,
                        confirmButtonText: 'Ya, Absen'
                    }).then(result => {
                        if (result.isConfirmed) {
                            document.getElementById('absenForm').submit();
                        } else {
                            resetBtn();
                        }
                    });
                },
                function () {
                    Swal.fire({
                        icon: 'error',
                        title: 'Lokasi tidak diizinkan'
                    });
                    resetBtn();
                }
            );
        });

        function resetBtn() {
            snap.disabled = false;
            snap.innerText = 'Absen Sekarang';
        }
    </script>

@endsection