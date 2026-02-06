@extends('layouts.landing')

@section('content')
<div class="container py-5">

    <div class="row justify-content-center">
        <div class="col-md-4 text-center">

            <h3 class="mb-3">📸 Form Absensi</h3>

            <div class="card shadow-sm p-3">

                <video id="video" class="w-100 rounded mirror" autoplay></video>
                <canvas id="canvas" width="320" height="240" hidden></canvas>

                <button id="snap" class="btn btn-primary w-100 mt-2">
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

// Kamera mirror
navigator.mediaDevices.getUserMedia({ video: true })
.then(stream => {
    video.srcObject = stream;
})
.catch(err => {
    alert('Tidak bisa mengakses kamera: ' + err.message);
});

// Ambil lokasi: pertama pakai geolocation
navigator.geolocation.getCurrentPosition(
    function(pos) {
        latitude.value = pos.coords.latitude;
        longitude.value = pos.coords.longitude;
    },
    function(err) {
        console.warn('Geolocation gagal:', err.message);
        // Kalau gagal, pakai IP-based API
        fetch('https://ipapi.co/json/')
        .then(response => response.json())
        .then(data => {
            latitude.value = data.latitude || '-6.200000';
            longitude.value = data.longitude || '106.816666';
            console.log('Lokasi dari IP:', latitude.value, longitude.value);
        })
        .catch(() => {
            // Fallback default
            latitude.value = '-6.200000';
            longitude.value = '106.816666';
        });
    }
);

snap.addEventListener("click", function () {
    const context = canvas.getContext('2d');
    canvas.width = video.videoWidth;
    canvas.height = video.videoHeight;
    context.drawImage(video, 0, 0);

    let image = canvas.toDataURL('image/png');
    photoInput.value = image;

    document.getElementById('absenForm').submit();
});
</script>
@endsection
