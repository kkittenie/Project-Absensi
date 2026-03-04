@extends('layouts.admin')

@section('title', 'Edit Admin | Admin')

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/admin/css/guru.css') }}">
@endpush

@section('content')
    <div class="container-fluid p-0">

        <div class="page-header row mb-4">
            <div class="col-12">
                <h1 class="h3 mb-0"><strong>Edit</strong> Admin</h1>
                <p class="text-muted mb-0">Edit data admin</p>
            </div>
        </div>

        <div class="card">
            <div class="card-body">

                <form action="{{ route('admin.users.update', $user->uuid) }}" method="POST" enctype="multipart/form-data" id="formEditUser">
                    @csrf
                    @method('PUT')

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Nama</label>
                            <input type="text" name="name" value="{{ old('name', $user->name) }}"
                                class="form-control @error('name') is-invalid @enderror"
                                placeholder="Masukkan nama lengkap">
                            @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Username</label>
                            <input type="text" name="username" value="{{ old('username', $user->username) }}"
                                class="form-control @error('username') is-invalid @enderror"
                                placeholder="Masukkan username">
                            @error('username') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Password (opsional)</label>
                            <input type="password" name="password"
                                class="form-control @error('password') is-invalid @enderror"
                                placeholder="Kosongkan jika tidak diganti">
                            @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Konfirmasi Password</label>
                            <input type="password" name="password_confirmation" class="form-control"
                                placeholder="Ulangi password baru">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Role</label>
                            <select name="role" class="form-select">
                                <option value="superadmin" {{ $user->role == 'superadmin' ? 'selected' : '' }}>Superadmin</option>
                                <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
                            </select>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Status</label>
                            <select name="is_active" class="form-select">
                                <option value="1" {{ $user->is_active ? 'selected' : '' }}>Aktif</option>
                                <option value="0" {{ !$user->is_active ? 'selected' : '' }}>Nonaktif</option>
                            </select>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label">Foto</label>
                        <input type="file" name="photo" class="form-control @error('photo') is-invalid @enderror">
                        @error('photo') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        @if ($user->photo)
                            <div class="mt-2">
                                <img src="{{ asset('storage/' . $user->photo) }}" width="100" height="100"
                                    class="rounded-2 object-fit-cover">
                            </div>
                        @endif
                    </div>

                    <hr>

                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('admin.users.index') }}" class="btn btn-secondary" id="btnBatal">Batal</a>
                        <button type="submit" class="btn btn-primary">
                            <i data-feather="save" style="width:16px;height:16px;"></i> Update
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

        document.getElementById('formEditUser').addEventListener('submit', function(e) {
            e.preventDefault();
            Swal.fire({
                title: 'Konfirmasi', text: 'Update data admin ini?', icon: 'question',
                showCancelButton: true, confirmButtonColor: '#47b2e4', cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, Update!', cancelButtonText: 'Batal'
            }).then(r => { if (r.isConfirmed) this.submit(); });
        });

        document.getElementById('btnBatal').addEventListener('click', function(e) {
            e.preventDefault();
            const url = this.getAttribute('href');
            Swal.fire({
                title: 'Konfirmasi', text: 'Batalkan? Perubahan tidak akan disimpan.', icon: 'warning',
                showCancelButton: true, confirmButtonColor: '#dc3545', cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, Batalkan!', cancelButtonText: 'Tidak'
            }).then(r => { if (r.isConfirmed) window.location.href = url; });
        });

        @if ($errors->any())
            Swal.fire({ icon: 'error', title: 'Oops...', text: 'Terdapat kesalahan pada form. Silakan periksa kembali.', confirmButtonText: 'OK', confirmButtonColor: '#47b2e4' });
        @endif

    });
</script>
@endpush