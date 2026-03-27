<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use App\Models\Guru;
use App\Models\Waktu;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class AbsensiController extends Controller
{
    public function index()
    {
        $guru = auth('guru')->user();

        $canAbsen = false;

        if (Auth::guard('guru')->check()) {
            $canAbsen = true;
        }

        return view('absensi.index', compact('canAbsen'));
    }

    public function create()
    {
        $guru = auth()->guard('guru')->user();

        $canAbsen = $guru ? true : false;

        return view('absensi.index', compact('canAbsen'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'photo_base64' => 'required',
            'latitude' => 'required',
            'longitude' => 'required',
        ]);

        $guru = auth()->guard('guru')->user();

        if (!$guru) {
            return back()->with('error', 'Akun belum terhubung dengan data guru');
        }

        $today = Carbon::today();

        $sudahAbsen = Absensi::where('guru_id', $guru->id)
            ->whereDate('waktu_absen', $today)
            ->exists();

        if ($sudahAbsen) {
            return back()->with('error', 'Kamu sudah absen hari ini ❌');
        }

        // ================= FOTO =================
        $base64Image = $request->photo_base64;

        $base64Image = preg_replace(
            '#^data:image/\w+;base64,#i',
            '',
            $base64Image
        );

        $fileName = 'absensi/' . Str::uuid() . '.png';

        Storage::disk('public')->put(
            $fileName,
            base64_decode($base64Image)
        );

        // ================= SIMPAN ABSENSI =================
        Absensi::create([
            'uuid' => Str::uuid(),
            'guru_id' => $guru->id,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'photo' => $fileName,
            'status' => 'hadir',
            'waktu_absen' => now(),
        ]);

        // ================= SIMPAN KE TABEL WAKTU =================
        $waktu = Waktu::where('guru_id', $guru->id)
            ->whereDate('created_at', $today)
            ->first();

        $now = Carbon::now();

        if (!$waktu) {

            // ABSEN MASUK
            Waktu::create([
                'guru_id' => $guru->id,
                'jam_masuk' => $now->format('H:i:s'),
            ]);

        } elseif (!$waktu->jam_pulang) {

            // ABSEN PULANG
            $waktu->update([
                'jam_pulang' => $now->format('H:i:s'),
            ]);
        }

        return back()->with('success', '✅ Absensi berhasil!');
    }
}