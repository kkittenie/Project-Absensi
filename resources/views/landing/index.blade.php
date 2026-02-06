@extends('layouts.landing')

@section('title', 'Beranda | SiHadir')

@section('content')

    {{-- Hero Section --}}
    <section id="hero" class="hero section dark-background">
        <div class="container">
            <div class="row gy-4">
                <div class="col-lg-6 d-flex flex-column justify-content-center" data-aos="zoom-out">
                    <h1>Selamat Datang di Sistem Informasi Kehadiran</h1>
                    <p>SMP PGRI Sumber</p>
                    <div class="d-flex">
                        <a href="{{ route('absensi.form') }}" class="btn-get-started">Form Absensi</a>
                        <a href="#" class="btn-get-started">Pengajuan Izin</a>
                        <a href="#" class="btn-get-started">Status Izin</a>
                    </div>
                </div>

                <div class="col-lg-6 hero-img" data-aos="zoom-out" data-aos-delay="200">
                    <img src="{{ asset('assets/landing/img/hero-img.png') }}" class="img-fluid animated" alt="">
                </div>
            </div>
        </div>
    </section>

    {{-- About --}}
    <section id="about" class="about section">
        <div class="container section-title" data-aos="fade-up">
            <h2>Tentang Kami</h2>
        </div>
        <div class="container">
            <div class="row gy-4">
                <div class="col-lg-6 content" data-aos="fade-up" data-aos-delay="100">
                    <p>
                        SiHadir adalah platform absensi sekolah berbasis digital yang dirancang untuk mempermudah proses
                        pencatatan kehadiran siswa dan guru secara cepat, akurat, dan efisien. Sistem ini hadir sebagai
                        solusi modern untuk menggantikan metode absensi manual, sehingga data kehadiran dapat dikelola
                        dengan lebih rapi dan transparan.
                    </p>
                    <ul>
                        <li><i class="bi bi-check2-circle"></i> <span>Absensi Terpusat untuk Siswa & Guru</span></li>
                        <li><i class="bi bi-check2-circle"></i> <span>Data Otomatis & Mudah Direkap</span></li>
                        <li><i class="bi bi-check2-circle"></i> <span>Monitoring Kehadiran Real-Time</span></li>
                    </ul>
                </div>
                <div class="col-lg-6" data-aos="fade-up" data-aos-delay="200">
                    <p>Website ini membantu guru dan pihak sekolah dalam memantau kehadiran siswa secara real-time,
                        sekaligus memberikan kemudahan bagi siswa dalam melakukan absensi harian. Dengan tampilan yang
                        sederhana dan fitur yang mudah digunakan, kami berkomitmen untuk mendukung digitalisasi pendidikan.
                    </p>
                </div>
            </div>
        </div>
    </section>

    {{-- Why Us --}}
    <section id="why-us" class="section why-us light-background" data-builder="section">
        <div class="container-fluid">
            <div class="row gy-4">
                <div class="col-lg-7 d-flex flex-column justify-content-center order-2 order-lg-1">
                    <div class="content px-xl-5" data-aos="fade-up" data-aos-delay="100">
                        <h3><span>Cara Menggunakan Website </span><strong>SiHadir</strong></h3>
                        <p>
                            Website ini memiliki tiga sistem utama untuk memudahkan absensi dan pengelolaan perizinan siswa
                            maupun guru.
                        </p>
                    </div>
                    <div class="faq-container px-xl-5" data-aos="fade-up" data-aos-delay="200">
                        <div class="faq-item faq-active">
                            <h3><span>01</span>Sistem Absen Harian </h3>
                            <div class="faq-content">
                                <p>Pengguna melakukan absensi dengan membuka kamera melalui website, lalu mengambil foto
                                    sebagai bukti kehadiran yang akan tersimpan otomatis di sistem.</p>
                            </div>
                            <i class="faq-toggle bi bi-chevron-right"></i>
                        </div>
                        <div class="faq-item">
                            <h3><span>02</span> Sistem Perizinan</h3>
                            <div class="faq-content">
                                <p>Pengguna dapat mengajukan izin atau surat keterangan kehadiran melalui sistem ini. Setiap
                                    pengajuan akan dikirimkan ke pihak sekolah untuk ditinjau dan disetujui.</p>
                            </div>
                            <i class="faq-toggle bi bi-chevron-right"></i>
                        </div>
                        <div class="faq-item">
                            <h3><span>03</span> Cek Status Perizinan </h3>
                            <div class="faq-content">
                                <p>Pengguna dapat memantau status pengajuan izin apakah sudah disetujui, ditolak, atau masih
                                    diproses melalui menu cek status perizinan.</p>
                            </div>
                            <i class="faq-toggle bi bi-chevron-right"></i>
                        </div>
                    </div>
                </div>
                <div class="col-lg-5 order-1 order-lg-2 why-us-img">
                    <img src="{{ asset('assets/landing/img/why-us.png') }}" class="img-fluid" alt="" data-aos="zoom-in"
                        data-aos-delay="100">
                </div>
            </div>
        </div>
    </section>

    {{-- Call To Action --}}
    <section id="call-to-action" class="call-to-action section dark-background">
        <img src="{{ asset('assets/landing/img/bg/bg-8.webp') }}" alt="">
        <div class="container">
            <div class="row" data-aos="zoom-in" data-aos-delay="100">
                <div class="col-xl-9 text-center text-xl-start">
                    <h3>Siap Beralih ke Absensi Digital?</h3>
                    <p>Website ini disediakan untuk membantu pihak sekolah dalam mencatat kehadiran siswa dan guru secara
                        digital melalui kamera, serta mengelola perizinan secara online. Dengan sistem ini, proses absensi
                        menjadi lebih tertib, data tersimpan dengan baik, dan monitoring kehadiran dapat dilakukan dengan
                        mudah.</p>
                </div>
                <div class="col-xl-3 cta-btn-container text-center">
                    <a class="cta-btn align-middle" href="#">Mulai Menggunakan</a>
                </div>
            </div>
        </div>
    </section>

    {{-- Contact --}}
    <section id="contact" class="contact section">
        <div class="container section-title" data-aos="fade-up">
            <h2>Kontak Kami</h2>
            <p>Untuk informasi lebih lanjut mengenai sistem absensi, silakan hubungi kami melalui kontak di bawah ini.</p>
        </div>
        <div class="container" data-aos="fade-up" data-aos-delay="100">
            <div class="row gy-4">
                <div class="col-lg-5">
                    <div class="info-wrap">
                        <div class="info-item d-flex" data-aos="fade-up" data-aos-delay="200">
                            <i class="bi bi-geo-alt flex-shrink-0"></i>
                            <div>
                                <h3>Alamat</h3>
                                <p>Jalan Sunan Drajat No. 20 B, Sumber, Kecamatan Sumber, Kabupaten Cirebon, Jawa Barat.</p>
                            </div>
                        </div>
                        <div class="info-item d-flex" data-aos="fade-up" data-aos-delay="300">
                            <i class="bi bi-telephone flex-shrink-0"></i>
                            <div>
                                <h3>Telepon Kami</h3>
                                <p>+62 813 9574 4204</p>
                            </div>
                        </div>
                        <div class="info-item d-flex" data-aos="fade-up" data-aos-delay="400">
                            <i class="bi bi-envelope flex-shrink-0"></i>
                            <div>
                                <h3>Email Kami</h3>
                                <p>smppgrisumber@gmail.com</p>
                            </div>
                        </div>
                        <iframe
                            src="https://maps.google.com/maps?width=600&amp;height=400&amp;hl=en&amp;q=SMP PGRI SUMBER&amp;t=&amp;z=16&amp;ie=UTF8&amp;iwloc=B&amp;output=embed"
                            frameborder="0" style="border:0; width: 100%; height: 270px;" allowfullscreen="" loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade"></iframe>
                    </div>
                </div>
                <div class="col-lg-7">
                    <form action="forms/contact.php" method="post" class="php-email-form" data-aos="fade-up"
                        data-aos-delay="200">
                        <div class="row gy-4">
                            <div class="col-md-6">
                                <label for="name-field" class="pb-2">Nama Lengkap</label>
                                <input type="text" name="name" id="name-field" class="form-control"
                                    required="">
                            </div>
                            <div class="col-md-6">
                                <label for="email-field" class="pb-2">Email</label>
                                <input type="email" class="form-control" name="email" id="email-field"
                                    required="">
                            </div>
                            <div class="col-md-12">
                                <label for="subject-field" class="pb-2">Subjek</label>
                                <input type="text" class="form-control" name="subject" id="subject-field"
                                    required="">
                            </div>
                            <div class="col-md-12">
                                <label for="message-field" class="pb-2">Pesan</label>
                                <textarea class="form-control" name="message" rows="10" id="message-field" required=""></textarea>
                            </div>
                            <div class="col-md-12 text-center">
                                <div class="loading">Memuat</div>
                                <div class="error-message"></div>
                                <div class="sent-message">Pesan Kamu Sudah Terkirim. Terima Kasih!</div>
                                <button type="submit">Kirim Pesan</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection
