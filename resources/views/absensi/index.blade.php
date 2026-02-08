@extends('layouts.landing')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@section('content')
    @if(session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Berhasil',
                text: '{{ session('success') }}',
                timer: 2500,
                showConfirmButton: false
            })
        </script>
    @endif

    @if(session('error'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Gagal',
                text: '{{ session('error') }}'
            })
        </script>
    @endif

    <div class="container py-5">

        <div class="row justify-content-center">
            <div class="col-md-4 text-center">

                <h3 class="mb-3">📸 Form Absensi</h3>

                <div class="card shadow-sm p-3">

                    <video id="video" class="w-100 rounded mirror" autoplay></video>
                    <canvas id="canvas" width="320" height="240" hidden></canvas>

                    <button type="button" id="snap" class="btn btn-primary w-100 mt-2">
                        Absen Sekarang
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

    <style>
        .mirror {
            transform: scaleX(-1);
        }
    </style>

    <script>
        const video = document.getElementById('video');
        const canvas = document.getElementById('canvas');
        const snap = document.getElementById('snap');
        const photoInput = document.getElementById('photo');
        const latitude = document.getElementById('latitude');
        const longitude = document.getElementById('longitude');

        // Kamera
        navigator.mediaDevices.getUserMedia({ video: true })
            .then(stream => {
                video.srcObject = stream;
            })
            .catch(err => {
                Swal.fire({
                    icon: 'error',
                    title: 'Kamera Error',
                    text: err.message
                });
            });

        // Lokasi
        navigator.geolocation.getCurrentPosition(
            function (pos) {
                latitude.value = pos.coords.latitude;
                longitude.value = pos.coords.longitude;
            },
            function () {
                fetch('https://ipapi.co/json/')
                    .then(res => res.json())
                    .then(data => {
                        latitude.value = data.latitude || '-6.200000';
                        longitude.value = data.longitude || '106.816666';
                    })
                    .catch(() => {
                        latitude.value = '-6.200000';
                        longitude.value = '106.816666';
                    });
            }
        );

        snap.addEventListener("click", function () {

            if (video.videoWidth === 0) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Kamera belum siap',
                    text: 'Tunggu beberapa detik ya'
                });
                return;
            }

            if (!latitude.value || !longitude.value) {
                Swal.fire({
                    icon: 'error',
                    title: 'Lokasi belum tersedia',
                    text: 'Mohon izinkan lokasi'
                });
                return;
            }

            Swal.fire({
                title: 'Memproses Absensi',
                text: 'Mohon tunggu...',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            const context = canvas.getContext('2d');
            canvas.width = video.videoWidth;
            canvas.height = video.videoHeight;
            context.drawImage(video, 0, 0);

            photoInput.value = canvas.toDataURL('image/png');

            setTimeout(() => {
                document.getElementById('absenForm').submit();
            }, 500);
        });
    </script>
@endsection