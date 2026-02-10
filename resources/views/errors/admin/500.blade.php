@extends('errors.admin.layouts.error')

@section('title', '500 | Kesalahan Server')

@section('content')
    <h1 class="display-1 fw-bold text-danger">500</h1>

    <h2 class="mb-3">Terjadi Kesalahan</h2>

    <p class="text-muted mb-4">
        Sistem sedang mengalami gangguan.
        Silakan coba lagi beberapa saat.
    </p>

    <a href="{{ route('admin.dashboard') }}" class="btn btn-primary">
        Kembali ke Dashboard
    </a>
@endsection
