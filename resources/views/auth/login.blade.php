@extends('layouts.auth')

@section('title', 'Login | Admin')

@section('content')
    <div class="container d-flex flex-column">
        <div class="row vh-100">
            <div class="col-sm-10 col-md-8 col-lg-6 col-xl-5 mx-auto d-table h-100">
                <div class="d-table-cell align-middle">

                    <div class="text-center mt-4">
                        <h1 class="h2">Selamat Datang!</h1>
                        <p class="lead">
                            Masuk untuk melanjutkan
                        </p>
                    </div>

                    <div class="card">
                        <div class="card-body">
                            <div class="m-sm-3">

                                @if ($errors->any())
                                    <x-alert type="danger" title="Login Gagal">
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

                                <form method="POST" action="{{ route('login') }}">
                                    @csrf

                                    <div class="mb-3">
                                        <label class="form-label">NIP</label>
                                        <input class="form-control form-control-lg" type="text" name="nip"
                                            value="{{ old('nip') }}" placeholder="Masukan NIP" required autofocus>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Password</label>
                                        <input class="form-control form-control-lg" type="password" name="password"
                                            placeholder="Masukan Password">
                                    </div>

                                    <div class="mb-3">
                                        <div class="form-check align-items-center">
                                            <input class="form-check-input" type="checkbox" name="remember" id="remember"
                                                {{ old('remember') ? 'checked' : '' }}>
                                            <label class="form-check-label" for="remember">
                                                Ingat Saya
                                            </label>
                                        </div>
                                    </div>

                                    <div class="d-grid gap-2 mt-3">
                                        <button type="submit" class="btn btn-lg btn-primary">
                                            Masuk
                                        </button>
                                    </div>
                                </form>

                            </div>
                        </div>
                    </div>

                    <div class="text-center mb-3">
                        Kembali ke
                        <a href="{{ route('landing.index') }}">Landing Page</a>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
