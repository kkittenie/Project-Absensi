<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Guru;
use App\Models\Waktu;
use Carbon\Carbon;

class WaktuController extends Controller
{
    public function index()
    {
        $gurus = Guru::with(['waktus' => function ($q) {
            $q->whereDate('tanggal', now()->toDateString());
        }])->get();

        return view('admin.waktu.index', compact('gurus'));
    }

    public function masuk(Guru $guru)
    {
        $now = Carbon::now();

        Waktu::create([
            'guru_id'   => $guru->id,
            'tanggal'   => $now->toDateString(),
            'jam_masuk' => $now->format('H:i:s'),
        ]);

        return back()->with('success', 'Absen masuk berhasil');
    }

    public function pulang(Guru $guru)
    {
        $waktu = Waktu::where('guru_id', $guru->id)
            ->whereDate('tanggal', now()->toDateString())
            ->firstOrFail();

        if ($waktu->jam_pulang) {
            return back()->with('error', 'Sudah absen pulang');
        }

        $waktu->update([
            'jam_pulang' => now()->format('H:i:s'),
        ]);

        return back()->with('success', 'Absen pulang berhasil');
    }
}
