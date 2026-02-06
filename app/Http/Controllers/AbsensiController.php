<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use App\Models\Guru;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;


class AbsensiController extends Controller
{
    public function create()
    {
        $gurus = Guru::where('is_active', true)->get();

        return view('absensi.create', compact('gurus'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'photo' => 'required',
            'latitude' => 'required',
            'longitude' => 'required',
        ]);

        // Ambil guru yang terkait dengan user
        $guru = auth()->user()->guru;

        if (!$guru) {
            return back()->with('error', 'Akun ini belum terhubung dengan data guru.');
        }

        // Cegah absen lebih dari sekali per hari
        $sudahAbsen = Absensi::where('guru_id', $guru->id)
            ->whereDate('waktu_absen', now())
            ->exists();

        if ($sudahAbsen) {
            return back()->with('error', 'Kamu sudah absen hari ini.');
        }

        // ================= FOTO =================
        $imageData = $request->photo;
        $imageData = str_replace('data:image/png;base64,', '', $imageData);
        $imageData = str_replace(' ', '+', $imageData);

        $imageName = 'absensi/' . Str::uuid() . '.png';

        // Simpan di storage/public/absensi
        Storage::disk('public')->put($imageName, base64_decode($imageData));

        // ================= SIMPAN ABSENSI =================
        $absensi = Absensi::create([
            'uuid' => Str::uuid(),
            'guru_id' => $guru->id,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'photo' => $imageName,
            'status' => 'hadir',
            'waktu_absen' => now(),
        ]);

        // ================= RETURN =================
        return back()->with('success', 'Absensi berhasil ✅');
    }
}

