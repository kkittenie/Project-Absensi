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
