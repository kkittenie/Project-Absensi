@extends('layouts.admin')

@section('title', 'Manajemen Users | Admin')

@section('content')

    @if ($errors->any())
        <x-alert type="danger" title="Gagal!">
            <ul class="mb-0 ps-3">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </x-alert>
    @endif

    @if (session('success'))
        <x-alert type="success">
            {{ session('success') }}
        </x-alert>
    @endif

    <div class="container-fluid p-0">

        {{-- PAGE TITLE --}}
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div class="col-5">
                <h1 class="h3 mb-0">
                    <strong>Manajemen Pengguna</strong> Admin
                </h1>
                <p class="text-muted">
                    Ringkasan data pengguna
                </p>
            </div>

            <a href="{{ route('admin.user.create') }}" class="btn btn-primary">
                <i data-feather="plus"></i>
                Tambah Pengguna
            </a>
        </div>

        {{-- TABS --}}
        <ul class="nav nav-tabs mb-3">
            <li class="nav-item">
                <a class="nav-link {{ request('status', 'active') === 'active' ? 'active' : '' }}"
                    href="{{ route('admin.user.index', ['status' => 'active']) }}">
                    Pengguna Aktif
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request('status') === 'inactive' ? 'active' : '' }}"
                    href="{{ route('admin.user.index', ['status' => 'inactive']) }}">
                    Pengguna Tidak Aktif
                </a>
            </li>
        </ul>

        {{-- TABLE --}}
        <div class="card">
            <div class="card-body">

                <div class="table-responsive">
                    <table class="table table-striped table-hover align-middle">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Foto</th>
                                <th>Nama</th>
                                <th>Username</th>
                                <th>Role</th>
                                <th>Status</th>
                                <th class="text-end">Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse ($users as $user)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>

                                    <td>
                                        <img src="{{ $user->photo ? asset('storage/' . $user->photo) : asset('assets/admin/img/avatars/default.jpg') }}"
                                            class="rounded-2 object-fit-cover" width="40" height="40">
                                    </td>

                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->username }}</td>png

                                    <td>
                                        <span class="badge bg-secondary">
                                            {{ $user->role }}
                                        </span>
                                    </td>

                                    <td>
                                        @if ($user->is_active)
                                            <span class="badge bg-success">Aktif</span>
                                        @else
                                            <span class="badge bg-danger">Tidak Aktif</span>
                                        @endif
                                    </td>

                                    <td class="text-end">
                                        @if ($user->is_active)
                                            <a href="{{ route('admin.user.edit', $user->uuid) }}"
                                                class="btn btn-sm btn-warning">
                                                <i data-feather="edit"></i>
                                            </a>

                                            @if ($user->uuid !== auth()->user()->uuid)
                                                <form action="{{ route('admin.user.deactivate', $user->uuid) }}"
                                                    method="POST" class="d-inline">
                                                    @csrf
                                                    @method('put')
                                                    <button class="btn btn-sm btn-danger"
                                                        onclick="return confirm('Nonaktifkan pengguna ini?')">
                                                        <i data-feather="user-x"></i>
                                                    </button>
                                                </form>
                                            @endif
                                        @else
                                            <form action="{{ route('admin.user.remove', $user->uuid) }}" method="POST"
                                                class="d-inline"
                                                onsubmit="return confirm('Yakin ingin menghapus pengguna ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-sm btn-outline-danger">
                                                    <i data-feather="trash-2"></i>
                                                </button>
                                            </form>

                                            <form action="{{ route('admin.user.activate', $user->uuid) }}" method="POST"
                                                class="d-inline">
                                                @csrf
                                                @method('put')
                                                <button class="btn btn-sm btn-success"
                                                    onclick="return confirm('Aktifkan pengguna ini?')">
                                                    <i data-feather="user-check"></i>
                                                </button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center text-muted py-4">
                                        Data pengguna tidak ditemukan
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>

                    </table>
                </div>

            </div>
        </div>

    </div>
@endsection
