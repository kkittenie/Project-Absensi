<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Kehadiran - {{ $tab === 'masuk' ? 'Absen Masuk' : 'Absen Pulang' }}</title>
    <style>
        @page {
            margin: 0;
            size: A4;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Times New Roman', Times, serif;
            font-size: 12px;
            color: #000;
            background: #fff;
            padding: 30px 40px;
        }

        .kop {
            display: flex;
            align-items: center;
            gap: 16px;
            padding-bottom: 10px;
            border-bottom: 3px double #000;
            margin-bottom: 6px;
        }

        .kop img {
            width: 70px;
            height: 70px;
            object-fit: contain;
        }

        .kop-text {
            flex: 1;
            text-align: center;
        }

        .kop-text .instansi {
            font-size: 15px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .kop-text .alamat {
            font-size: 10px;
            margin-top: 2px;
            color: #333;
        }

        .garis-bawah-kop {
            border-bottom: 1px solid #000;
            margin-bottom: 14px;
        }

        .judul {
            text-align: center;
            margin-bottom: 14px;
        }

        .judul h3 {
            font-size: 13px;
            font-weight: bold;
            text-transform: uppercase;
            text-decoration: underline;
            letter-spacing: 0.5px;
        }

        .info-dokumen {
            margin-bottom: 14px;
        }

        .info-dokumen table {
            border: none;
            margin-bottom: 0;
            width: auto;
        }

        .info-dokumen td {
            padding: 2px 4px;
            border: none;
            font-size: 11.5px;
            vertical-align: top;
            text-align: left;
            white-space: nowrap;
        }

        .info-dokumen td:first-child {
            width: 130px;
        }

        .info-dokumen td:nth-child(2) {
            width: 16px;
            text-align: center;
        }

        .info-dokumen td:nth-child(3) {
            font-weight: normal;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            font-size: 11.5px;
        }

        thead tr {
            background: #000;
            color: #fff;
        }

        thead th {
            padding: 6px 8px;
            text-align: center;
            font-size: 11px;
            font-weight: bold;
            border: 1px solid #000;
        }

        tbody td {
            padding: 5px 8px;
            border: 1px solid #555;
            vertical-align: middle;
            text-align: center;
        }

        tbody tr:nth-child(even) {
            background: #f2f2f2;
        }

        .td-left {
            text-align: left !important;
        }

        .status {
            font-size: 10px;
            font-weight: bold;
        }

        .status-tepat {
            color: #1a7a1a;
        }

        .status-terlambat {
            color: #856404;
        }

        .status-izin {
            color: #0c5460;
        }

        .status-alpha {
            color: #721c24;
        }

        .status-lembur {
            color: #0c5460;
        }

        .status-cepat {
            color: #721c24;
        }

        .empty {
            color: #777;
            font-style: italic;
            text-align: center;
        }

        .footer {
            margin-top: 20px;
            display: flex;
            justify-content: flex-end;
        }

        .ttd {
            text-align: center;
            width: 200px;
            font-size: 11.5px;
        }

        .ttd .kota-tanggal {
            margin-bottom: 4px;
        }

        .ttd .jabatan {
            margin-bottom: 60px;
        }

        .ttd .nama-ttd {
            font-weight: bold;
            text-decoration: underline;
            margin-bottom: 2px;
        }

        .ttd .nip-ttd {
            font-size: 10.5px;
        }

        @media print {
            body {
                padding: 20px 30px;
            }

            thead tr {
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }

            tbody tr:nth-child(even) {
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
        }
    </style>
</head>

<body>

    <div class="kop">
        <img src="{{ asset('assets/landing/img/logo.png') }}" alt="Logo">
        <div class="kop-text">
            <div class="instansi">SMP PGRI Sumber</div>
            <div class="alamat">
                Jl. Sunan Drajat No.20 B, Sumber, Kec. Sumber, Kabupaten Cirebon, Jawa Barat 45611<br>
                Telp. (0231) 000000 | Email: <a href="/cdn-cgi/l/email-protection" class="__cf_email__"
                    data-cfemail="b7c4dac7d0c5dec4c2dad5d2c5f7d0dad6dedb99d4d8da">[email&#160;protected]</a>
            </div>
        </div>
        <img src="{{ asset('assets/landing/img/logo.png') }}" alt="Logo" style="visibility:hidden;">
    </div>
    <div class="garis-bawah-kop"></div>

    <div class="judul">
        <h3>Rekap {{ $tab === 'masuk' ? 'Absen Masuk' : 'Absen Pulang' }} Guru</h3>
    </div>

    <div class="info-dokumen">
        <table>
            <tr>
                <td>Periode</td>
                <td>:</td>
                <td>{{ \Carbon\Carbon::createFromDate($tahun, $bulan, 1)->translatedFormat('F Y') }}</td>
            </tr>
            <tr>
                <td>Jenis Absen</td>
                <td>:</td>
                <td>{{ $tab === 'masuk' ? 'Absen Masuk' : 'Absen Pulang' }}</td>
            </tr>
            <tr>
                <td>Jumlah Guru</td>
                <td>:</td>
                <td>{{ $data->pluck('guru_id')->unique()->count() }} guru</td>
            </tr>
            <tr>
                <td>Tanggal Cetak</td>
                <td>:</td>
                <td>{{ now()->locale('id')->isoFormat('dddd, D MMMM Y') }}, Pukul {{ now()->format('H:i') }} WIB</td>
            </tr>
        </table>
    </div>

    @if($tab === 'masuk')
        <table>
            <thead>
                <tr>
                    <th width="4%">No.</th>
                    <th width="25%">Nama Guru</th>
                    <th width="20%">Mata Pelajaran</th>
                    <th width="22%">Tanggal</th>
                    <th width="12%">Jam Masuk</th>
                    <th width="17%">Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($data as $index => $k)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td class="td-left"><strong>{{ $k->guru->nama_guru }}</strong></td>
                        <td>{{ $k->guru->mapel->nama_mapel ?? '-' }}</td>
                        <td>{{ \Carbon\Carbon::parse($k->tanggal)->locale('id')->isoFormat('dddd, D MMM Y') }}</td>
                        <td>{{ $k->jam_masuk ? \Carbon\Carbon::parse($k->jam_masuk)->format('H:i') : '-' }}</td>
                        <td>
                            @php $status = $k->absensi?->status ?? null; @endphp
                            @if($status === 'tepat_waktu')
                                <span class="status status-tepat">&#10003; Tepat Waktu</span>
                            @elseif($status === 'terlambat')
                                <span class="status status-terlambat">&#9888; Terlambat</span>
                            @elseif($status === 'izin')
                                <span class="status status-izin">&#9432; Izin</span>
                            @elseif($status === 'alpha')
                                <span class="status status-alpha">&#10007; Alpha</span>
                            @else
                                <span class="status">-</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="empty">Tidak ada data absen masuk</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

    @else
        <table>
            <thead>
                <tr>
                    <th width="4%">No.</th>
                    <th width="25%">Nama Guru</th>
                    <th width="20%">Mata Pelajaran</th>
                    <th width="22%">Tanggal</th>
                    <th width="12%">Jam Pulang</th>
                    <th width="17%">Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($data as $index => $k)
                    @php
                        $tanggal = \Carbon\Carbon::parse($k->tanggal)->toDateString();
                        $key = $k->guru_id . '_' . $tanggal;

                        $absensi = $k->absensi;
                        $dataIzin = $izins[$key] ?? null;
                    @endphp

                    <tr>
                        <td>{{ $index + 1 }}</td>

                        <td class="td-left">
                            <strong>{{ $k->guru->nama_guru }}</strong>
                        </td>

                        <td>{{ $k->guru->mapel->nama_mapel ?? '-' }}</td>

                        <td>
                            {{ \Carbon\Carbon::parse($k->tanggal)->locale('id')->isoFormat('dddd, D MMM Y') }}
                        </td>

                        <td>
                            {{ $k->jam_pulang
                    ? \Carbon\Carbon::parse($k->jam_pulang)->format('H:i')
                    : '-' }}
                        </td>

                        <td>
                            @if($dataIzin)
                                <span class="status status-izin">
                                    &#9432; {{ ucfirst($dataIzin->jenis_izin) }}
                                </span>

                            @elseif($absensi?->status_pulang === 'pulang_cepat')
                                <span class="status status-cepat">
                                    &#9888; Pulang Cepat ({{ (int) ($absensi->selisih_pulang_cepat ?? 0) }} mnt)
                                </span>

                            @elseif($absensi?->status_pulang === 'lembur')
                                <span class="status status-lembur">
                                    &#9200; Lembur {{ (int) ($absensi->lembur_menit ?? 0) }} mnt
                                </span>

                            @elseif($absensi?->status_pulang === 'tepat_waktu')
                                <span class="status status-tepat">
                                    &#10003; Tepat Waktu
                                </span>

                            @else
                                <span class="status">-</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="empty">Tidak ada data absen pulang</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    @endif

    <div class="footer">
        <div class="ttd">
            <p class="kota-tanggal">Sumber, {{ now()->locale('id')->isoFormat('D MMMM Y') }}</p>
            <p class="jabatan">Kepala Sekolah</p>
            <p class="nama-ttd">( ................................. )</p>
            <p class="nip-ttd">NIP. ..............................