@extends('errors.admin.layouts.error')

@section('title', '403 | Akses Ditolak')

@section('content')
    <h1 class="display-1 fw-bold text-danger">403</h1>

    <h2 class="mb-3">Akses Ditolak</h2>

    <p class="text-muted mb-4">
        Kamu tidak memiliki izin untuk mengakses halaman ini.
    </p>

    <a href="{{ route('admin.dashboard') }}" class="btn btn-primary">
        Kembali ke Dashboard
    </a>
@endsection
