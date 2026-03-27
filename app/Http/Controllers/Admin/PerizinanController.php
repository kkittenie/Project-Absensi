<?php

namespace App\Http\Controllers\Admin;

use App\Models\Izin;
use App\Models\Absensi;
use App\Models\Kehadiran;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PerizinanController extends Controller
{
    public function index(Request $request)
    {
        $bulan  = $request->get('bulan', date('n'));
        $tahun  = $request->get('tahun', date('Y'));
        $status = $request->get('status');
        $nama   = $request->get('nama');

        $izins = Izin::with('guru')
            ->whereMonth('tanggal_izin', $bulan)
            ->whereYear('tanggal_izin', $tahun)
            ->when($status, fn($q) => $q->where('status', $status))
            ->when($nama, fn($q) => $q->whereHas('guru', fn($q) => $q->where('nama_guru', 'like', "%{$nama}%")))
            ->orderBy('tanggal_izin', 'desc')
            ->get();

        return view('admin.perizinan.index', compact('izins'));
    }

    public function approve($id)
    {
        $izin = Izin::findOrFail($id);
        $izin->update(['status' => 'disetujui']);

        $tanggal = $izin->tanggal_izin;

        $absensiAda = Absensi::where('guru_id', $izin->guru_id)
            ->whereDate('tanggal', $tanggal)
            ->exists();

        if (!$absensiAda) {
            Absensi::create([
                'uuid'    => Str::uuid(),
                'guru_id' => $izin->guru_id,
                'tanggal' => $tanggal,
                'status'  => 'izin',
            ]);

            $kehadiranAda = Kehadiran::where('guru_id', $izin->guru_id)
                ->where('tanggal', $tanggal)
                ->exists();

            if (!$kehadiranAda) {
                Kehadiran::create([
                    'guru_id'    => $izin->guru_id,
                    'tanggal'    => $tanggal,
                    'jam_masuk'  => null,
                    'jam_pulang' => null,
                ]);
            }
        }

        return back()->with('success', 'Izin disetujui');
    }

    public function reject($id)
    {
        $izin = Izin::findOrFail($id);
        $izin->update(['status' => 'ditolak']);

        // Hapus absensi izin yang sudah dibuat saat approve
        Absensi::where('guru_id', $izin->guru_id)
            ->whereDate('tanggal', $izin->tanggal_izin)
            ->where('status', 'izin')
            ->delete();

        // Hapus kehadiran kosong yang dibuat saat approve
        Kehadiran::where('guru_id', $izin->guru_id)
            ->where('tanggal', $izin->tanggal_izin)
            ->whereNull('jam_masuk')
            ->whereNull('jam_pulang')
            ->delete();

        // Ganti dengan alpha jika belum ada absensi lain di tanggal itu
        $absensiAda = Absensi::where('guru_id', $izin->guru_id)
            ->whereDate('tanggal', $izin->tanggal_izin)
            ->exists();

        if (!$absensiAda) {
            Absensi::create([
                'uuid'    => Str::uuid(),
                'guru_id' => $izin->guru_id,
                'tanggal' => $izin->tanggal_izin,
                'status'  => 'alpha',
            ]);

            Kehadiran::create([
                'guru_id'    => $izin->guru_id,
                'tanggal'    => $izin->tanggal_izin,
                'jam_masuk'  => null,
                'jam_pulang' => null,
            ]);
        }

        return back()->with('success', 'Izin ditolak');
    }

    public function cetak(Request $request)
    {
        $bulan  = $request->get('bulan', date('n'));
        $tahun  = $request->get('tahun', date('Y'));
        $status = $request->get('status');
        $nama   = $request->get('nama');

        $izins = Izin::with('guru')
            ->whereMonth('tanggal_izin', $bulan)
            ->whereYear('tanggal_izin', $tahun)
            ->when($status, fn($q) => $q->where('status', $status))
            ->when($nama, fn($q) => $q->whereHas('guru', fn($q) => $q->where('nama_guru', 'like', "%{$nama}%")))
            ->orderBy('tanggal_izin', 'desc')
            ->get();

        return view('admin.perizinan.cetak', compact('izins', 'bulan', 'tahun', 'status'));
    }

    public function surat(Izin $izin)
    {
        return view('admin.perizinan.surat', compact('izin'));
    }
}