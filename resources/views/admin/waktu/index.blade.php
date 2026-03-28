@extends('layouts.admin')

@section('title', 'Pengaturan Jam Kehadiran | Admin')

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/admin/css/guru.css') }}">
@endpush

@section('content')
<div class="container-fluid p-0">

    <div class="page-header mb-4">
        <h1 class="h3 mb-0"><strong>Pengaturan</strong> Jam Kehadiran</h1>
        <p class="text-muted mb-0">Ubah jam masuk, batas terlambat, dan jam pulang</p>
    </div>

    <div class="card">
        <div class="card-body">

            <form action="{{ route('admin.jam_kehadiran.update', $jam->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row g-3">

                    <div class="col-md-6">
                        <label class="form-label">Jam Mulai Tap In</label>
                        <input type="time" name="mulai_tap_in" value="{{ old('mulai_tap_in', $jam->mulai_tap_in) }}" class="form-control" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Jam Akhir Tap In</label>
                        <input type="time" name="akhir_tap_in" value="{{ old('akhir_tap_in', $jam->akhir_tap_in) }}" class="form-control" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Batas Keterlambatan</label>
                        <input type="time" name="batas_terlambat" value="{{ old('batas_terlambat', $jam->batas_terlambat) }}" class="form-control" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Jam Mulai Tap Out</label>
                        <input type="time" name="mulai_tap_out" value="{{ old('mulai_tap_out', $jam->mulai_tap_out) }}" class="form-control" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Jam Akhir Tap Out</label>
                        <input type="time" name="akhir_tap_out" value="{{ old('akhir_tap_out', $jam->akhir_tap_out) }}" class="form-control" required>
                    </div>

                </div>

                <div class="mt-4 text-end">
                    <button type="submit" class="btn btn-primary">
                        <i data-feather="save"></i> Simpan
                    </button>
                </div>

            </form>

        </div>
    </div>

</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
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
                html: `<ul class="text-start mb-0" style="list-style-position: inside;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                    </ul>`,
                confirmButtonText: 'OK',
                confirmButtonColor: '#47b2e4'
            });
        @endif
    });
</script>
@endpush