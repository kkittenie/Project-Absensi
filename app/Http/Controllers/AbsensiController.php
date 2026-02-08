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
            'photo_base64' => 'required',
            'latitude' => 'required',
            'longitude' => 'required',
        ]);

        $guru = auth()->user()->guru;

        if (!$guru) {
            return back()->with('error', 'Akun belum terhubung dengan guru.');
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

        // ================= DATABASE =================
        Absensi::create([
            'uuid' => Str::uuid(),
            'guru_id' => $guru->id,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'photo' => $fileName, // ⬅️ PATH RELATIF
            'status' => 'hadir',
            'waktu_absen' => now(),
        ]);

        return back()->with('success', '✅ Absensi berhasil!');
    }
}

