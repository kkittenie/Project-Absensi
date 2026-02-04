<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <title>@yield('title', 'Admin Error')</title>

    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{-- AdminKit CSS --}}
    <link href="{{ asset('assets/admin/css/app.css') }}" rel="stylesheet">

</head>

<body>

    <main class="d-flex w-100">
        <div class="container d-flex flex-column">
            <div class="row vh-100">
                <div class="col-sm-10 col-md-8 col-lg-6 mx-auto d-table h-100">
                    <div class="d-table-cell align-middle">

                        {{-- CONTENT --}}
                        <div class="text-center">
                            @yield('content')
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </main>

    {{-- AdminKit JS --}}
    <script src="{{ asset('assets/admin/js/app.js') }}"></script>
</body>

</html>
