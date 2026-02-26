@extends('layouts.admin')

@section('title', 'Surat Izin Guru | Admin')

@section('content')

<div class="container-fluid p-0">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h1 class="h3 mb-0">
                <strong>Surat</strong> Izin Guru
            </h1>
            <p class="text-muted">
                Dokumen surat izin yang diajukan
            </p>
        </div>
    </div>

    <div class="card">
        <div class="card-body text-center">
            <img src="{{ asset('storage/'.$izin->foto_surat) }}"
                 class="img-fluid rounded shadow-sm"
                 style="max-height: 80vh;">
        </div>
    </div>

    <div class="mt-3">
        <a href="{{ url()->previous() }}" class="btn btn-secondary">
            ← Kembali
        </a>
    </div>

</div>
@endsection
