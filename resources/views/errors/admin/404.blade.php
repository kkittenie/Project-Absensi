@extends('errors.admin.layouts.error')

@section('title', '404 | Halaman Tidak Ditemukan')

@section('content')
    <h1 class="display-1 fw-bold text-warning">404</h1>

    <h2 class="mb-3">Halaman Tidak Ditemukan</h2>

    <p class="text-muted mb-4">
        Halaman admin yang kamu cari tidak tersedia atau sudah dipindahkan.
    </p>

    <a href="{{ route('admin.dashboard') }}" class="btn btn-primary">
        Kembali ke Dashboard
    </a>
@endsection
