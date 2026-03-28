<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use App\Models\Kehadiran;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class AbsensiController extends Controller
{
    const JAM_MASUK_MULAI    = '06:00';
    const JAM_MASUK_SELESAI  = '09:00';
    const JAM_PULANG_MULAI   = '13:00';
    const JAM_PULANG_SELESAI = '15:00';

    public function index()
    {
        $guru     = auth('guru')->user();
        $canAbsen = Auth::guard('guru')->check();

        $absenHariIni     = null;
        $kehadiranHariIni = null;
        $sudahAbsenMasuk  = false;
        $sudahAbsenPulang = false;

        if ($guru) {
            $today = now()->toDateString();

            $absenHariIni = Absensi::where('guru_id', $guru->id)
                ->whereDate('created_at', $today)
                ->first();

            $kehadiranHariIni = Kehadiran::where('guru_id', $guru->id)
                ->where('tanggal', $today)
                ->first();

            $sudahAbsenMasuk  = $absenHariIni !== null;
            $sudahAbsenPulang = $kehadiranHariIni?->jam_pulang !== null;
        }

        return view('absensi.index', compact(
            'canAbsen',
            'absenHariIni',
            'kehadiranHariIni',
            'sudahAbsenMasuk',
            'sudahAbsenPulang',
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'photo_base64' => 'required',
            'latitude'     => 'required',
            'longitude'    => 'required',
            'mode'         => 'required|in:masuk,pulang',
        ]);

        $guru = auth()->guard('guru')->user();

        if (!$guru) {
            return back()->with('error', 'Akun belum terhubung dengan data guru');
        }

        $today     = now()->toDateString();
        $modeAbsen = $request->mode;

        $absenHariIni = Absensi::where('guru_id', $guru->id)
            ->whereDate('created_at', $today)
            ->first();

        $kehadiranHariIni = Kehadiran::where('guru_id', $guru->id)
            ->where('tanggal', $today)
            ->first();

        // Simpan foto
        $base64Image = preg_replace('#^data:image/\w+;base64,#i', '', $request->photo_base64);
        $fileName    = 'absensi/' . Str::uuid() . '.png';
        Storage::disk('public')->put($fileName, base64_decode($base64Image));

        // ===== ABSEN MASUK =====
        if ($modeAbsen === 'masuk') {
            if ($absenHariIni) {
                return back()->with('error', 'Kamu sudah absen masuk hari ini ❌');
            }

            $jamSekarang = now()->format('H:i');
            $status      = $jamSekarang <= '07:00' ? 'tepat_waktu' : 'terlambat';

            Absensi::create([
                'uuid'      => Str::uuid(),
                'guru_id'   => $guru->id,
                'photo'     => $fileName,
                'latitude'  => $request->latitude,
                'longitude' => $request->longitude,
                'status'    => $status,
            ]);

            Kehadiran::create([
                'guru_id'   => $guru->id,
                'tanggal'   => $today,
                'jam_masuk' => now()->format('H:i:s'),
            ]);

            $pesanStatus = $status === 'tepat_waktu' ? 'Tepat waktu 👍' : 'Terlambat ⚠️';
            return back()->with('success', "✅ Absen masuk berhasil! {$pesanStatus}");
        }

        // ===== ABSEN PULANG =====
        if ($modeAbsen === 'pulang') {
            if (!$absenHariIni) {
                return back()->with('error', 'Kamu belum absen masuk hari ini ❌');
            }
            if ($absenHariIni->status === 'alpha') {
                return back()->with('error', 'Kamu tercatat alpha hari ini ❌');
            }
            if ($kehadiranHariIni?->jam_pulang) {
                return back()->with('error', 'Kamu sudah absen pulang hari ini ❌');
            }

            $jamPulang   = now();
            $batasPulang = now()->setTimeFromTimeString(self::JAM_PULANG_SELESAI);
            $batasCepat  = now()->setTimeFromTimeString(self::JAM_PULANG_MULAI);
            $lemburMenit = $jamPulang->gt($batasPulang)
                ? $jamPulang->diffInMinutes($batasPulang)
                : 0;

            $absenHariIni->update([
                'photo_pulang'     => $fileName,
                'latitude_pulang'  => $request->latitude,
                'longitude_pulang' => $request->longitude,
            ]);

            if ($kehadiranHariIni) {
                $kehadiranHariIni->update([
                    'jam_pulang'   => now()->format('H:i:s'),
                    'lembur_menit' => $lemburMenit,
                ]);
            } else {
                Kehadiran::create([
                    'guru_id'      => $guru->id,
                    'tanggal'      => $today,
                    'jam_pulang'   => now()->format('H:i:s'),
                    'lembur_menit' => $lemburMenit,
                ]);
            }

            if ($lemburMenit > 0) {
                $pesan = "Lembur {$lemburMenit} menit ⏰";
            } elseif ($jamPulang->lt($batasCepat)) {
                $selisih = (int) $jamPulang->diffInMinutes($batasCepat);
                $pesan   = "Pulang cepat {$selisih} menit lebih awal ⚠️";
            } else {
                $pesan = 'Tepat waktu 👍';
            }

            return back()->with('success', "✅ Absen pulang berhasil! {$pesan}");
        }
    }

    public function cetak()
    {
        $data = Absensi::with('guru')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.kehadiran.cetak', compact('data'));
    }
}