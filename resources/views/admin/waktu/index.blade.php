@extends('layouts.admin')

@section('title', 'Pengaturan Jam Kehadiran & Hari Libur | Admin')

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/admin/css/guru.css') }}">
@endpush

@section('content')
<div class="container-fluid p-0">

    <div class="page-header mb-4">
        <h1 class="h3 mb-0"><strong>Pengaturan</strong> Jam Kehadiran</h1>
        <p class="text-muted mb-0">Ubah jam masuk, batas terlambat, dan jam pulang</p>
    </div>

    <div class="card mb-4">
        <div class="card-header">
            <div class="d-flex align-items-center gap-2">
                <div class="header-icon" style="width:36px;height:36px;border-radius:8px;background:linear-gradient(135deg,#47b2e4,#37517e);display:flex;align-items:center;justify-content:center;">
                    <i data-feather="clock" style="width:18px;height:18px;stroke:white;"></i>
                </div>
                <h5 class="card-title mb-0">Jam Absensi</h5>
            </div>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.jam_kehadiran.update', $jam->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row g-4">

                    <div class="col-md-6">
                        <h6 class="fw-bold text-primary mb-3">
                            <i data-feather="log-in" style="width:16px;height:16px;"></i> Absen Masuk
                        </h6>

                        <div class="mb-3">
                            <label class="form-label">Jam Mulai Tap In</label>
                            <input type="time" name="mulai_tap_in"
                                   value="{{ old('mulai_tap_in', $jam->mulai_tap_in) }}"
                                   class="form-control" required>
                            <small class="text-muted">Jam paling awal guru bisa absen masuk</small>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Batas Keterlambatan</label>
                            <input type="time" name="batas_terlambat"
                                   value="{{ old('batas_terlambat', $jam->batas_terlambat) }}"
                                   class="form-control" required>
                            <small class="text-muted">Lewat jam ini dianggap terlambat</small>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Jam Akhir Tap In</label>
                            <input type="time" name="akhir_tap_in"
                                   value="{{ old('akhir_tap_in', $jam->akhir_tap_in) }}"
                                   class="form-control" required>
                            <small class="text-muted">Jam terakhir guru bisa absen masuk</small>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <h6 class="fw-bold text-warning mb-3">
                            <i data-feather="log-out" style="width:16px;height:16px;"></i> Absen Pulang
                        </h6>

                        <div class="mb-3">
                            <label class="form-label">Jam Mulai Tap Out</label>
                            <input type="time" name="mulai_tap_out"
                                   value="{{ old('mulai_tap_out', $jam->mulai_tap_out) }}"
                                   class="form-control" required>
                            <small class="text-muted">Jam paling awal guru bisa absen pulang</small>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Jam Akhir Tap Out</label>
                            <input type="time" name="akhir_tap_out"
                                   value="{{ old('akhir_tap_out', $jam->akhir_tap_out) }}"
                                   class="form-control" required>
                            <small class="text-muted">Lewat jam ini dianggap lembur</small>
                        </div>
                    </div>

                    <div class="col-12">
                        <hr>
                        <h6 class="fw-bold text-secondary mb-3">
                            <i data-feather="calendar" style="width:16px;height:16px;"></i> Hari Libur Mingguan
                        </h6>
                        <div class="d-flex flex-wrap gap-3">
                            @foreach(['Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu'] as $hari)
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox"
                                           name="hari_libur_mingguan[]"
                                           value="{{ $hari }}"
                                           id="hari_{{ $hari }}"
                                           {{ in_array($hari, $jam->hari_libur_mingguan ?? []) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="hari_{{ $hari }}">
                                        {{ $hari }}
                                    </label>
                                </div>
                            @endforeach
                        </div>
                        <small class="text-muted">Guru tidak perlu absen di hari yang dicentang</small>
                    </div>

                </div>

                <div class="mt-4 text-end">
                    <button type="submit" class="btn btn-primary">
                        <i data-feather="save" style="width:16px;height:16px;"></i> Simpan Pengaturan
                    </button>
                </div>

            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center gap-2">
                <div class="header-icon" style="width:36px;height:36px;border-radius:8px;background:linear-gradient(135deg,#dc3545,#c82333);display:flex;align-items:center;justify-content:center;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24"
                         fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                        <line x1="16" y1="2" x2="16" y2="6"></line>
                        <line x1="8" y1="2" x2="8" y2="6"></line>
                        <line x1="3" y1="10" x2="21" y2="10"></line>
                    </svg>
                </div>
                <h5 class="card-title mb-0">Tanggal Merah / Libur Khusus</h5>
            </div>
            <button class="btn btn-sm btn-danger" id="btnTambahLibur">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24"
                     fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                     stroke-linejoin="round" style="margin-right:4px;margin-bottom:2px;">
                    <line x1="12" y1="5" x2="12" y2="19"></line>
                    <line x1="5" y1="12" x2="19" y2="12"></line>
                </svg>
                Tambah
            </button>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover align-middle">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Tanggal</th>
                            <th>Hari</th>
                            <th>Keterangan</th>
                            <th class="text-end">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($hariLiburs as $libur)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ \Carbon\Carbon::parse($libur->tanggal)->locale('id')->isoFormat('D MMMM Y') }}</td>
                                <td>{{ \Carbon\Carbon::parse($libur->tanggal)->locale('id')->isoFormat('dddd') }}</td>
                                <td>{{ $libur->keterangan ?? '-' }}</td>
                                <td class="text-end">
                                    <form action="{{ route('admin.jam_kehadiran.libur.destroy', $libur->id) }}"
                                          method="POST" class="d-inline form-hapus">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-sm btn-danger btn-hapus">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14"
                                                 viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                 stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                <polyline points="3 6 5 6 21 6"></polyline>
                                                <path d="M19 6l-1 14H6L5 6"></path>
                                                <path d="M10 11v6"></path>
                                                <path d="M14 11v6"></path>
                                                <path d="M9 6V4h6v2"></path>
                                            </svg>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted py-4">
                                    Belum ada hari libur khusus
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

<div class="modal fade" id="modalTambahLibur" tabindex="-1" aria-labelledby="modalTambahLiburLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <form action="{{ route('admin.jam_kehadiran.libur.store') }}" method="POST">
                @csrf
                <div class="modal-header border-0 pb-0">
                    <div class="d-flex align-items-center gap-2">
                        <div style="width:36px;height:36px;border-radius:8px;background:linear-gradient(135deg,#dc3545,#c82333);display:flex;align-items:center;justify-content:center;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24"
                                 fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                                <line x1="16" y1="2" x2="16" y2="6"></line>
                                <line x1="8" y1="2" x2="8" y2="6"></line>
                                <line x1="3" y1="10" x2="21" y2="10"></line>
                            </svg>
                        </div>
                        <h5 class="modal-title mb-0" id="modalTambahLiburLabel">Tambah Hari Libur</h5>
                    </div>
                    <button type="button" class="btn-close" id="btnTutupModal"></button>
                </div>
                <div class="modal-body pt-3">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Tanggal</label>
                        <input type="date" name="tanggal" class="form-control" required>
                    </div>
                    <div class="mb-1">
                        <label class="form-label fw-semibold">
                            Keterangan <span class="text-muted fw-normal">(Opsional)</span>
                        </label>
                        <input type="text" name="keterangan" class="form-control"
                               placeholder="Contoh: Hari Raya Idul Fitri">
                    </div>
                </div>
                <div class="modal-footer border-0 pt-0">
                    <button type="button" class="btn btn-secondary" id="btnBatalModal">Batal</button>
                    <button type="submit" class="btn btn-danger">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24"
                             fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                             stroke-linejoin="round" style="margin-right:4px;margin-bottom:2px;">
                            <line x1="12" y1="5" x2="12" y2="19"></line>
                            <line x1="5" y1="12" x2="19" y2="12"></line>
                        </svg>
                        Tambah
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
    document.addEventListener('DOMContentLoaded', function () {

        @if(session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: "{{ session('success') }}",
                showConfirmButton: false,
                timer: 2000,
                timerProgressBar: true,
            });
        @endif

        @if($errors->any())
            Swal.fire({
                icon: 'error',
                title: 'Gagal!',
                html: '<ul class="text-start mb-0" style="list-style-position: inside;">' +
                    @foreach($errors->all() as $error)
                        '<li>{{ $error }}</li>' +
                    @endforeach
                    '</ul>',
                confirmButtonText: 'OK',
            });
        @endif

        const modalEl      = document.getElementById('modalTambahLibur');
        const modalInstance = new bootstrap.Modal(modalEl);

        document.getElementById('btnTambahLibur').addEventListener('click', () => modalInstance.show());
        document.getElementById('btnTutupModal').addEventListener('click', () => modalInstance.hide());
        document.getElementById('btnBatalModal').addEventListener('click', () => modalInstance.hide());

        document.querySelectorAll('.btn-hapus').forEach(btn => {
            btn.addEventListener('click', function () {
                const form = this.closest('.form-hapus');
                Swal.fire({
                    title: 'Hapus Hari Libur?',
                    text: 'Data ini akan dihapus permanen.',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#dc3545',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Ya, Hapus',
                    cancelButtonText: 'Batal',
                }).then(result => {
                    if (result.isConfirmed) form.submit();
                });
            });
        });

    });
</script>
@endpush