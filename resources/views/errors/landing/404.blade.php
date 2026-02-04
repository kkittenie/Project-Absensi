<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>404 | Halaman Tidak Ditemukan</title>

    <!-- Favicons -->
    <link href="{{ asset('assets/landing/img/favicon.png') }}" rel="icon">
    <link href="{{ asset('assets/landing/img/apple-touch-icon.png') }}" rel="apple-touch-icon">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans&family=Poppins&family=Jost&display=swap"
        rel="stylesheet">

    <!-- Vendor CSS -->
    <link href="{{ asset('assets/landing/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/landing/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/landing/vendor/aos/aos.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/landing/vendor/glightbox/css/glightbox.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/landing/vendor/swiper/swiper-bundle.min.css') }}" rel="stylesheet">

    <!-- Main CSS -->
    <link href="{{ asset('assets/landing/css/main.css') }}" rel="stylesheet">
</head>

<body class="page-404">

    <!-- ======= Header (Non Fixed) ======= -->
    <header id="header" class="header d-flex align-items-center sticky-top">
        <div class="container-fluid container-xl d-flex align-items-center">

            <a href="{{ route('landing.index') }}" class="logo d-flex align-items-center me-auto">
                <img src="{{ asset('assets/landing/img/logo.png') }}" alt="Logo">
                <h1 class="sitename">SiHadir</h1>
            </a>

            <nav id="navmenu" class="navmenu">
                <ul>
                    <li><a href="{{ route('landing.index') }}#hero">Beranda</a></li>
                    <li><a href="{{ route('landing.index') }}#about">Tentang Kami</a></li>
                    <li><a href="{{ route('landing.index') }}#contact">Kontak</a></li>
                </ul>
                <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
            </nav>

            @if (auth()->check())
                <a href="{{ route('admin.dashboard') }}" class="btn-getstarted">
                    Dashboard
                </a>
            @else
                <a href="{{ route('login') }}" class="btn-getstarted">
                    Login
                </a>
            @endif
        </div>
    </header>
    <!-- End Header -->

    <main class="main">

        <!-- Page Title -->
        <div class="page-title" data-aos="fade">
            <div class="container">
                <nav class="breadcrumbs">
                    <ol>
                        <li>
                            <a href="{{ route('landing.index') }}">Beranda</a>
                        </li>
                        <li class="current">404</li>
                    </ol>
                </nav>
                <h1>404</h1>
            </div>
        </div>

        <!-- Error 404 Section -->
        <section id="error-404" class="error-404 section">
            <div class="container text-center" data-aos="fade-up">

                <div class="error-icon mb-4" data-aos="zoom-in">
                    <i class="bi bi-exclamation-circle"></i>
                </div>

                <h1 class="error-code mb-3">404</h1>

                <h2 class="error-title mb-3">
                    Oops! Halaman Tidak Ditemukan
                </h2>

                <p class="error-text mb-4">
                    Halaman yang kamu cari mungkin sudah dipindahkan,
                    dihapus, atau sementara tidak tersedia.
                </p>

                <a href="{{ route('landing.index') }}" class="btn btn-primary">
                    Kembali ke Beranda
                </a>
            </div>
        </section>

    </main>

    <!-- ======= Footer ======= -->
    <footer id="footer" class="footer">

        <div class="container footer-top">
            <div class="row gy-4">
                {{-- About --}}
                <div class="col-lg-4 col-md-6 footer-about">
                    <a href="{{ route('landing.index') }}" class="d-flex align-items-center">
                        <span class="sitename">SiHadir</span>
                    </a>
                    <div class="footer-contact pt-3">
                        <p>Jalan Sunan Drajat No. 20</p>
                        <p>Sumber, Kecamatan Sumber, Kabupaten Cirebon, Jawa Barat</p>
                        <p class="mt-3">
                            <strong>Telepon:</strong> <span>+62 813 9574 4204</span>
                        </p>
                        <p>
                            <strong>Email:</strong> <span>smppgrisumber@gmail.com</span>
                        </p>
                    </div>
                </div>

                {{-- Landing Links --}}
                <div class="col-lg-2 col-md-3 footer-links">
                    <h4>Navigasi</h4>
                    <ul>
                        <li>
                            <i class="bi bi-chevron-right"></i>
                            <a href="{{ route('landing.index') }}#hero">Beranda</a>
                        </li>
                        <li>
                            <i class="bi bi-chevron-right"></i>
                            <a href="{{ route('landing.index') }}#about">Tentang Kami</a>
                        </li>
                        <li>
                            <i class="bi bi-chevron-right"></i>
                            <a href="{{ route('landing.index') }}#contact">Kontak</a>
                        </li>
                    </ul>
                </div>

                {{-- Services --}}
                <div class="col-lg-2 col-md-3 footer-links">
                    <h4>Layanan</h4>
                    <ul>
                        <li><i class="bi bi-chevron-right"></i> <a href="#">Absensi Online</a></li>
                        <li><i class="bi bi-chevron-right"></i> <a href="#">Pengajuan Izin</a></li>
                        <li><i class="bi bi-chevron-right"></i> <a href="#">Rekap Kehadiran</a></li>
                    </ul>
                </div>

                {{-- Social --}}
                <div class="col-lg-4 col-md-12">
                    <h4>Ikuti Kami</h4>
                    <p>
                        Ikuti media sosial resmi kami untuk mendapatkan informasi terbaru
                        seputar kegiatan sekolah dan pembaruan sistem absensi.
                    </p>
                    <div class="social-links d-flex">
                        <a href="#" class="facebook">
                            <i class="bi bi-facebook"></i>
                        </a>
                        <a href="https://www.instagram.com/smp_pgri_sumber" class="instagram">
                            <i class="bi bi-instagram"></i>
                        </a>
                    </div>
                </div>

            </div>
        </div>

        {{-- Copyright --}}
        <div class="container copyright text-center mt-4">
            <p>
                © {{ date('Y') }}
                <strong class="px-1 sitename">SiHadir</strong>
                <span>All Rights Reserved</span>
            </p>
            <div class="credits">
                Didesain oleh <strong>SMKN 1 Kota Cirebon | XI RPL 1</strong>
            </div>
        </div>

    </footer>

    <!-- Scroll Top -->
    <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center">
        <i class="bi bi-arrow-up-short"></i>
    </a>

    <!-- Vendor JS -->
    <script src="{{ asset('assets/landing/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/landing/vendor/aos/aos.js') }}"></script>
    <script src="{{ asset('assets/landing/vendor/glightbox/js/glightbox.min.js') }}"></script>
    <script src="{{ asset('assets/landing/vendor/swiper/swiper-bundle.min.js') }}"></script>

    <!-- Main JS -->
    <script src="{{ asset('assets/landing/js/main.js') }}"></script>

</body>

</html>
