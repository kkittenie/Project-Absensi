<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title', 'Login')</title>

    <link rel="shortcut icon" href="{{ asset('assets/admin/img/icons/icon-48x48.png') }}">

    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <link href="{{ asset('assets/admin/css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/admin/css/components.css') }}" rel="stylesheet">
</head>

<body>
    <main class="d-flex w-100">
        @yield('content')
    </main>

    <script src="{{ asset('assets/admin/js/app.js') }}"></script>
</body>

</html>
