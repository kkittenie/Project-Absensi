@extends('layouts.landing')

@section('content')

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

{{-- SWEET ALERT --}}
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

@if ($errors->any())
<script>
    Swal.fire({
        icon: 'error',
        title: 'Validasi gagal',
        html: `{!! implode('<br>', $errors->all()) !!}`
    });
</script>
@endif

<section class="section dark-background" style="padding-top:120px">
    <div class="container">
        <div class="row justify-content-center">

            <div class="col-md-5 text-center">

                <h3 class="mb-3">📝 Form Izin Guru</h3>

                <div class="card shadow p-4 text-start">

                    <form action="{{ route('guru.izin.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <!-- Jenis Izin -->
                        <div class="mb-3">
                            <label class="form-label">Jenis Izin</label>
                            <select name="jenis_izin" class="form-control">
                                <option value="">-- Pilih --</option>
                                <option value="sakit">Sakit</option>
                                <option value="izin">Izin</option>
                                <option value="lainnya">Lainnya</option>
                            </select>
                        </div>

                        <!-- Alasan -->
                        <div class="mb-3">
                            <label class="form-label">Alasan</label>
                            <textarea
                                name="alasan"
                                class="form-control"
                                rows="3"
                                placeholder="Isi alasan izin"
                            ></textarea>
                        </div>

                        <!-- Tanggal -->
                        <div class="mb-3">
                            <label class="form-label">Tanggal Izin</label>
                            <input type="date" name="tanggal_izin" class="form-control">
                        </div>

                        <!-- Foto -->
                        <div class="mb-3">
                            <label class="form-label">
                                Foto Surat <span class="text-muted">(Opsional)</span>
                            </label>
                            <input type="file" name="foto_surat" class="form-control">
                        </div>

                        <button type="submit" class="btn btn-primary w-100">
                            Kirim Izin
                        </button>

                    </form>

                </div>

            </div>

        </div>
    </div>
</section>

@endsection
