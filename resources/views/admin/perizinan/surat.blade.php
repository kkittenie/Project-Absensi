@extends('layouts.admin')

@section('title', 'Surat Izin Guru | Admin')

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/admin/css/guru.css') }}">
@endpush

@section('content')

<div class="container-fluid p-0">

    <div class="page-header row mb-4">
        <div class="col-12">
            <h1 class="h3 mb-0"><strong>Surat</strong> Izin Guru</h1>
            <p class="text-muted mb-0">Dokumen surat izin yang diajukan</p>
        </div>
    </div>

    <div class="card">
        <div class="card-body text-center p-4">
            <img src="{{ asset('storage/'.$izin->foto_surat) }}"
                 class="img-fluid rounded shadow-sm"
                 style="max-height: 75vh; border: 3px solid #e1e8ed;">
        </div>
    </div>

    <div class="mt-3 d-flex gap-2">
        <a href="{{ url()->previous() }}" class="btn btn-secondary">
            <i data-feather="arrow-left" style="width:16px;height:16px;"></i> Kembali
        </a>
        
        <a href="{{ asset('storage/'.$izin->foto_surat) }}" 
           target="_blank" 
           class="btn btn-primary">
            <i data-feather="external-link" style="width:16px;height:16px;"></i> Buka di Tab Baru
        </a>
    </div>

</div>
@endsection