<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kehadiran;
use App\Models\Absensi;
use App\Models\Izin;
use App\Models\Waktu;
use Illuminate\Http\Request;

class KehadiranController extends Controller
{
    public function index(Request $request)
    {
        $bulan = $request->get('bulan', date('n'));
        $tahun = $request->get('tahun', date('Y'));
        $nama = $request->get('nama');
        $jam = Waktu::first();

        $query = Kehadiran::with(['guru.mapel'])
            ->whereMonth('tanggal', $bulan)
            ->whereYear('tanggal', $tahun);

        if ($nama) {
            $query->whereHas('guru', fn($q) => $q->where('nama_guru', 'like', "%{$nama}%"));
        }

        $absenMasuk = (clone $query)->orderBy('tanggal', 'desc')->get();
        $absenPulang = (clone $query)->whereNotNull('jam_pulang')->orderBy('tanggal', 'desc')->get();

        $absensiMap = Absensi::whereIn('guru_id', $absenMasuk->pluck('guru_id'))
            ->whereMonth('created_at', $bulan)
            ->whereYear('created_at', $tahun)
            ->get()
            ->keyBy(fn($a) => $a->guru_id . '_' . \Carbon\Carbon::parse($a->created_at)->toDateString());

        $izins = Izin::with('guru')
            ->whereMonth('tanggal_izin', $bulan)
            ->whereYear('tanggal_izin', $tahun)
            ->where('status', 'disetujui')
            ->get()
            ->keyBy(fn($i) => $i->guru_id . '_' . $i->tanggal_izin);

        return view('admin.kehadiran.index', compact(
            'absenMasuk',
            'absenPulang',
            'bulan',
            'tahun',
            'nama',
            'absensiMap',
            'izins',
            'jam'
        ));
    }

    public function cetak(Request $request)
    {
        $bulan = $request->get('bulan', date('n'));
        $tahun = $request->get('tahun', date('Y'));
        $tab = $request->get('tab', 'masuk');

        $data = Kehadiran::with(['guru.mapel'])
            ->whereMonth('tanggal', $bulan)
            ->whereYear('tanggal', $tahun)
            ->when($tab === 'pulang', fn($q) => $q->whereNotNull('jam_pulang'))
            ->orderBy('tanggal', 'desc')
            ->get();

        $absensiMap = Absensi::whereIn('guru_id', $data->pluck('guru_id'))
            ->whereMonth('tanggal', $bulan)
            ->whereYear('tanggal', $tahun)
            ->get()
            ->keyBy(fn($a) => $a->guru_id . '_' . \Carbon\Carbon::parse($a->tanggal)->toDateString());

        $data->each(function ($k) use ($absensiMap) {
            $key = $k->guru_id . '_' . \Carbon\Carbon::parse($k->tanggal)->toDateString();
            $k->setRelation('absensi', $absensiMap->get($key));
        });

        $izins = Izin::with('guru')
            ->whereMonth('tanggal_izin', $bulan)
            ->whereYear('tanggal_izin', $tahun)
            ->where('status', 'disetujui')
            ->get()
            ->keyBy(fn($i) => $i->guru_id . '_' . $i->tanggal_izin);

        return view('admin.kehadiran.cetak', compact('data', 'bulan', 'tahun', 'tab', 'izins'));
    }
}