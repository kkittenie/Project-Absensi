<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use App\Models\Kehadiran;
use Illuminate\Http\Request;
use Carbon\Carbon;

class KehadiranController extends Controller
{
    /**
     * TAMPILAN KEHADIRAN HARI INI
     */
    public function index()
    {
        $gurus = Guru::with(['kehadirans' => function ($q) {
            $q->whereDate('tanggal', now());
        }])->where('is_active', true)->get();

        return view('kehadiran.index', compact('gurus'));
    }

    /**
     * ABSEN MASUK (MAX JAM 07:00)
     */
    public function absenMasuk($uuid)
    {
        $guru = Guru::where('uuid', $uuid)->firstOrFail();
        $now  = Carbon::now();

        // ❌ lewat jam 07:00
        if ($now->format('H:i') > '07:00') {
            return back()->with('error', 'Terlambat! Absen masuk hanya sampai jam 07:00');
        }

        // ❌ sudah absen hari ini
        $exists = Kehadiran::where('guru_id', $guru->id)
            ->whereDate('tanggal', today())
            ->first();

        if ($exists) {
            return back()->with('error', 'Guru sudah absen hari ini');
        }

        Kehadiran::create([
            'guru_id'   => $guru->id,
            'tanggal'   => today(),
            'jam_masuk' => $now->format('H:i:s'),
            'lembur_menit' => 0,
        ]);

        return back()->with('success', 'Absen masuk berhasil');
    }

    /**
     * ABSEN PULANG (LEMBUR SETELAH 12:30)
     */
    public function absenPulang($id)
    {
        $kehadiran = Kehadiran::findOrFail($id);
        $now = Carbon::now();

        // jam pulang normal 12:30
        $jamPulangNormal = Carbon::createFromTime(12, 30);

        $lembur = 0;
        if ($now->greaterThan($jamPulangNormal)) {
            $lembur = $jamPulangNormal->diffInMinutes($now);
        }

        $kehadiran->update([
            'jam_pulang'   => $now->format('H:i:s'),
            'lembur_menit' => $lembur,
        ]);

        return back()->with('success', 'Absen pulang berhasil');
    }

    /**
     * INVOICE / REKAP KEHADIRAN
     */
    public function invoice($uuid)
    {
        $guru = Guru::where('uuid', $uuid)->firstOrFail();

        $kehadirans = Kehadiran::where('guru_id', $guru->id)
            ->orderBy('tanggal', 'desc')
            ->get();

        return view('kehadiran.invoice', compact('guru', 'kehadirans'));
    }
}
