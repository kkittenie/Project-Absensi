@extends('layouts.admin')

@section('title', 'Manajemen Guru | Admin')

@section('content')

    @if (session('success'))
        <x-alert type="success">
            {{ session('success') }}
        </x-alert>
    @endif

    <div class="container-fluid p-0">

        <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
                <h1 class="h3 mb-0">
                    <strong>Manajemen Guru</strong>
                </h1>
                <p class="text-muted">Ringkasan data guru</p>
            </div>

            <a href="{{ route('admin.guru.create') }}" class="btn btn-primary">
                <i data-feather="plus"></i> Tambah Guru
            </a>
        </div>

        {{-- Tabs --}}
        <ul class="nav nav-tabs mb-3">
            <li class="nav-item">
                <a class="nav-link {{ request('status', 'active') === 'active' ? 'active' : '' }}"
                    href="{{ route('admin.guru.index', ['status' => 'active']) }}">
                    Guru Aktif
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link {{ request('status') === 'inactive' ? 'active' : '' }}"
                    href="{{ route('admin.guru.index', ['status' => 'inactive']) }}">
                    Guru Tidak Aktif
                </a>
            </li>
        </ul>

        <div class="card">
            <div class="card-body">

                <table class="table table-striped align-middle">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Foto</th>
                            <th>Nama</th>
                            <th>Mapel</th>
                            <th>NIP</th>
                            <th>Status</th>
                            <th class="text-end">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($gurus as $guru)
                            <tr>
                                <td>{{ $loop->iteration }}</td>

                                <td>
                                    <img src="{{ $guru->photo ? asset('storage/' . $guru->photo) : asset('assets/admin/img/avatars/default.jpg') }}"
                                        width="40" height="40" class="rounded-2 object-fit-cover">
                                </td>

                                <td>{{ $guru->nama_guru }}</td>
                                <td>{{ $guru->mata_pelajaran }}</td>
                                <td>{{ $guru->nip }}</td>

                                <td>
                                    @if($guru->is_active)
                                        <span class="badge bg-success">Aktif</span>
                                    @else
                                        <span class="badge bg-danger">Tidak Aktif</span>
                                    @endif
                                </td>

                                <td class="text-end">
                                    @if($guru->is_active)
                                        <a href="{{ route('admin.guru.edit', $guru->uuid) }}" class="btn btn-sm btn-warning">
                                            <i data-feather="edit"></i>
                                        </a>

                                        <form action="{{ route('admin.guru.deactivate', $guru->uuid) }}" method="POST"
                                            class="d-inline">
                                            @csrf
                                            @method('PUT')
                                            <button class="btn btn-sm btn-danger" onclick="return confirm('Nonaktifkan guru ini?')">
                                                <i data-feather="user-x"></i>
                                            </button>
                                        </form>
                                    @else
                                        <form action="{{ route('admin.guru.remove', $guru->uuid) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-outline-danger"
                                                onclick="return confirm('Hapus guru ini?')">
                                                <i data-feather="trash-2"></i>
                                            </button>
                                        </form>

                                        <form action="{{ route('admin.guru.activate', $guru->uuid) }}" method="POST"
                                            class="d-inline">
                                            @csrf
                                            @method('PUT')
                                            <button class="btn btn-sm btn-success">
                                                <i data-feather="user-check"></i>
                                            </button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted py-4">
                                    Data guru tidak ditemukan
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

            </div>
        </div>

    </div>
@endsection