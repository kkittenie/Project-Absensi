@extends('layout.app')
<x-app-layout>
<div class="container mt-4">

    <h3 class="mb-4">Form Izin Guru</h3>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card">
        <div class="card-body">
            <form action="{{ route('izin.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <!-- Guru -->
                <div class="mb-3">
                    <label class="form-label">Guru</label>
                    <select name="guru_id" class="form-control">
                        <option value="">-- Pilih Guru --</option>
                        @foreach ($gurus as $guru)
                            <option value="{{ $guru->id }}">
                                {{ $guru->nama_guru }} ({{ $guru->nip }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Jenis Izin -->
                <div class="mb-3">
                    <label class="form-label">Jenis Izin</label>
                    <select name="jenis_izin" class="form-control" id="jenisIzin">
                        <option value="">-- Pilih --</option>
                        <option value="sakit">Sakit</option>
                        <option value="izin">Izin</option>
                        <option value="lainnya">Lainnya</option>
                    </select>
                </div>

                <!-- Alasan -->
                <div class="mb-3">
                    <label class="form-label">Alasan</label>
                    <textarea name="alasan" class="form-control" rows="3"
                        placeholder="Isi alasan izin (wajib untuk izin & lainnya)"></textarea>
                </div>

                <!-- Tanggal -->
                <div class="mb-3">
                    <label class="form-label">Tanggal Izin</label>
                    <input type="date" name="tanggal_izin" class="form-control">
                </div>

                <!-- Foto Surat -->
                <div class="mb-3">
                    <label class="form-label">Foto Surat Izin (Opsional)</label>
                    <input type="file" name="foto_surat" class="form-control">
                </div>

                <button type="submit" class="btn btn-primary">Kirim Izin</button>
                <a href="{{ route('guru.index') }}" class="btn btn-secondary">Kembali</a>
            </form>
        </div>
    </div>

</div>
</x-app-layout>
