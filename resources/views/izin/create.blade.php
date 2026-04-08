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

    @if($errors->any())
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Validasi Gagal',
                html: `{!! implode('<br>', $errors->all()) !!}`
            });
        </script>
    @endif

    <section class="section dark-background" style="padding-top:120px">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-5 text-center">

                    <h3 class="mb-3">📝 Form Izin Guru</h3>

                    @php
                        $sudahIzinHariIni = false;
                        $sudahAbsenLengkap = false;
                        $guru = auth()->guard('guru')->user();

                        if ($guru) {
                            $today = now()->toDateString();

                            $sudahIzinHariIni = \App\Models\Izin::where('guru_id', $guru->id)
                                ->whereDate('tanggal_izin', $today)
                                ->exists();

                            $sudahAbsenLengkap = \App\Models\Kehadiran::where('guru_id', $guru->id)
                                ->whereDate('tanggal', $today)
                                ->whereNotNull('jam_masuk')
                                ->whereNotNull('jam_pulang')
                                ->exists();
                        }
                    @endphp

                    @if($isLibur)
                        <div class="alert alert-secondary">
                            🏖️ Hari ini adalah hari libur, tidak bisa mengajukan izin
                        </div>

                    @elseif($sudahIzinHariIni)
                        <div class="alert alert-warning">
                            📋 Kamu sudah mengajukan izin untuk hari ini
                        </div>

                    @elseif($sudahAbsenLengkap)
                        <div class="alert alert-info">
                            ✅ Kamu sudah absen lengkap hari ini, tidak perlu mengajukan izin
                        </div>

                    @else
                        <div class="card shadow p-4 text-start">
                            <form action="{{ route('guru.izin.store') }}" method="POST" enctype="multipart/form-data"
                                id="izinForm">
                                @csrf

                                <div class="mb-3">
                                    <label class="form-label">Jenis Izin</label>
                                    <select name="jenis_izin" class="form-control" required>
                                        <option value="">-- Pilih --</option>
                                        <option value="sakit" {{ old('jenis_izin') === 'sakit' ? 'selected' : '' }}>Sakit</option>
                                        <option value="izin" {{ old('jenis_izin') === 'izin' ? 'selected' : '' }}>Izin</option>
                                        <option value="lainnya" {{ old('jenis_izin') === 'lainnya' ? 'selected' : '' }}>Lainnya
                                        </option>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Alasan</label>
                                    <textarea name="alasan" class="form-control" rows="3" placeholder="Isi alasan izin"
                                        required>{{ old('alasan') }}</textarea>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Tanggal Izin</label>
                                    <input type="date" name="tanggal_izin" class="form-control"
                                        value="{{ old('tanggal_izin', now()->toDateString()) }}"
                                        min="{{ now()->toDateString() }}" required>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">
                                        Foto Surat <span class="text-muted">(Opsional)</span>
                                    </label>
                                    <input type="file" name="foto_surat" class="form-control" accept="image/*,.pdf">
                                </div>

                                <button type="button" id="btnKirim" class="btn btn-primary w-100">
                                    Kirim Izin
                                </button>
                            </form>
                        </div>
                    @endif
                    <div class="back-link mt-3">
                        <a href="{{ route('landing.index') }}" style="color: #fff;">
                            <i class="bi bi-arrow-left"></i> Kembali ke Beranda
                        </a>
                    </div>

                </div>
            </div>
        </div>
    </section>

    <script>
        const JAM_MASUK_MULAI = "{{ $jam->mulai_tap_in }}";
        const JAM_MASUK_SELESAI = "{{ $jam->akhir_tap_in }}";
        const JAM_PULANG_MULAI = "{{ $jam->mulai_tap_out }}";
        const JAM_PULANG_SELESAI = "{{ $jam->akhir_tap_out }}";
        const IS_LIBUR = {{ $isLibur ? 'true' : 'false' }};

        function getMode() {
            const jam = new Date().toTimeString().slice(0, 5);
            if (jam >= JAM_MASUK_MULAI && jam <= JAM_MASUK_SELESAI) return 'masuk';
            if (jam >= JAM_PULANG_MULAI && jam <= JAM_PULANG_SELESAI) return 'pulang';
            return 'tutup';
        }

        const btnKirim = document.getElementById('btnKirim');

        if (btnKirim) {
            btnKirim.addEventListener('click', function () {
                const tanggalIzin = document.querySelector('input[name=tanggal_izin]').value;
                const today = new Date().toISOString().split('T')[0];
                const jamSekarang = new Date().toTimeString().slice(0, 5);

                if (IS_LIBUR && tanggalIzin === today) {
                    Swal.fire({
                        icon: 'info',
                        title: 'Hari Libur',
                        text: 'Hari ini adalah hari libur, tidak bisa mengajukan izin.'
                    });
                    return;
                }

                if (tanggalIzin === today && jamSekarang > JAM_PULANG_SELESAI) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Waktu Pengajuan Habis',
                        text: `Pengajuan izin untuk hari ini sudah tidak bisa dilakukan setelah jam ${JAM_PULANG_SELESAI}.`,
                        confirmButtonText: 'Mengerti',
                        confirmButtonColor: '#0d6efd',
                    });
                    return;
                }

                Swal.fire({
                    icon: 'question',
                    title: 'Konfirmasi Pengajuan',
                    text: 'Yakin ingin mengajukan izin?',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, Kirim',
                    cancelButtonText: 'Batal',
                    confirmButtonColor: '#0d6efd',
                    cancelButtonColor: '#6c757d',
                }).then(result => {
                    if (result.isConfirmed) {
                        document.getElementById('izinForm').submit();
                    }
                });
            });
        }
    </script>

@endsection