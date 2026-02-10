<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title', 'Admin Dashboard')</title>

    <link rel="shortcut icon" href="{{ asset('assets/admin/img/icons/icon-48x48.png') }}">

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
    <link href="{{ asset('assets/admin/css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/admin/css/components.css') }}" rel="stylesheet">

    @stack('styles')
</head>

<body>
    <div class="wrapper">

        {{-- Sidebar --}}
        @include('components.admin.sidebar')

        <div class="main">

            {{-- Navbar --}}
            @include('components.admin.navbar')

            {{-- Content --}}
            <main class="content">
                <div class="container-fluid p-0">
                    @yield('content')
                </div>
            </main>

            {{-- Footer --}}
            @include('components.admin.footer')

        </div>
    </div>

    <script src="{{ asset('assets/admin/js/app.js') }}"></script>
    @stack('scripts')
</body>

</html>
