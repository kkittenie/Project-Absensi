<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Guru;
use App\Models\Kehadiran;
use Illuminate\Http\Request;
use Carbon\Carbon;

class KehadiranController extends Controller
{
    // Menampilkan daftar kehadiran guru hari ini
    public function index()
    {
        // Ambil guru beserta kehadiran hari ini
        $gurus = Guru::with(['kehadiran' => function ($q) {
            $q->whereDate('tanggal', Carbon::now('Asia/Jakarta')->toDateString());
        }])->get();

        return view('admin.kehadiran.index', compact('gurus'));
    }

    // Absen masuk guru
    public function masuk(Guru $guru)
    {
        // Pastikan waktu WIB
        $waktuSekarang = Carbon::now('Asia/Jakarta');

        Kehadiran::create([
            'guru_id' => $guru->id,
            'tanggal' => $waktuSekarang->toDateString(),
            'jam_masuk' => $waktuSekarang->toTimeString(),
            'lembur_menit' => 0,
        ]);

        return back()->with('success', 'Absen masuk berhasil dicatat!');
    }

    // Absen pulang guru dengan catatan dan status
    public function pulang(Request $request, Kehadiran $kehadiran)
    {
        $waktuSekarang = Carbon::now('Asia/Jakarta');

        $kehadiran->update([
            'jam_pulang' => $waktuSekarang->toTimeString(),
            'catatan' => $request->catatan ?? null,
            'status_pulang' => $request->status_pulang ?? null,
        ]);

        return back()->with('success', 'Absen pulang berhasil dicatat!');
    }
  public function invoice($kehadiranId)
    {
        $kehadiran = Kehadiran::findOrFail($kehadiranId);
        $guru = $kehadiran->guru;
        $kehadirans = Kehadiran::where('guru_id', $guru->id)
                                ->orderBy('tanggal', 'asc')
                                ->get();

        return view('admin.kehadiran.invoice', compact('guru', 'kehadirans'));
    }
}


