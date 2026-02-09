@extends('layout.app')
<x-app-layout>

<div class="container mt-4">
    <h4 class="mb-3">Surat Izin</h4>

    <img src="{{ asset('storage/'.$izin->foto_surat) }}"
         class="img-fluid rounded shadow">

    <div class="mt-4">
        <a href="{{ url()->previous() }}" class="btn btn-secondary">
            ← Kembali
        </a>
    </div>
</div>

</x-app-layout>
