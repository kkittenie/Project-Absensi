<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use App\Models\Kehadiran;
use App\Models\Waktu;
use App\Models\HariLibur;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class AbsensiController extends Controller
{
    private function getJam(): Waktu
    {
        return Waktu::first() ?? new Waktu([
            'mulai_tap_in' => '06:00',
            'akhir_tap_in' => '09:00',
            'batas_terlambat' => '07:00',
            'mulai_tap_out' => '13:00',
            'akhir_tap_out' => '15:00',
            'hari_libur_mingguan' => ['Sabtu', 'Minggu'],
        ]);
    }

    private function isHariLibur(string $tanggal): bool
    {
        $jam = $this->getJam();
        $carbon = Carbon::parse($tanggal);
        $namaHari = $carbon->locale('id')->isoFormat('dddd');

        if (in_array($namaHari, $jam->hari_libur_mingguan ?? [])) {
            return true;
        }

        return HariLibur::where('tanggal', $tanggal)->exists();
    }

    private function getModeAbsen(Waktu $jam): string
    {
        $waktu = now()->format('H:i');

        if ($waktu >= $jam->mulai_tap_in && $waktu <= $jam->akhir_tap_in) {
            return 'masuk';
        }
        if ($waktu >= $jam->mulai_tap_out && $waktu <= $jam->akhir_tap_out) {
            return 'pulang';
        }

        return 'tutup';
    }

    public function index()
    {
        $guru = auth('guru')->user();
        $canAbsen = Auth::guard('guru')->check();

        $absenHariIni = null;
        $kehadiranHariIni = null;
        $sudahAbsenMasuk = false;
        $sudahAbsenPulang = false;
        $isLibur = false;
        $jam = $this->getJam();

        if ($guru) {
            $today = now()->toDateString();

            $isLibur = $this->isHariLibur($today);

            $absenHariIni = Absensi::where('guru_id', $guru->id)
                ->whereDate('created_at', $today)
                ->first();

            $kehadiranHariIni = Kehadiran::where('guru_id', $guru->id)
                ->where('tanggal', $today)
                ->first();

            $sudahAbsenMasuk = $absenHariIni !== null;
            $sudahAbsenPulang = $kehadiranHariIni?->jam_pulang !== null;
        }

        return view('absensi.index', compact(
            'canAbsen',
            'absenHariIni',
            'kehadiranHariIni',
            'sudahAbsenMasuk',
            'sudahAbsenPulang',
            'isLibur',
            'jam',
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'photo_base64' => 'required',
            'latitude' => 'required',
            'longitude' => 'required',
            'mode' => 'required|in:masuk,pulang',
        ]);

        $guru = auth()->guard('guru')->user();

        if (!$guru) {
            return back()->with('error', 'Akun belum terhubung dengan data guru');
        }

        $today = now()->toDateString();
        $jam = $this->getJam();

        if ($this->isHariLibur($today)) {
            return back()->with('error', 'Hari ini adalah hari libur, tidak perlu absen ❌');
        }

        $modeAbsen = $request->mode;
        $absenHariIni = Absensi::where('guru_id', $guru->id)->whereDate('created_at', $today)->first();
        $kehadiranHariIni = Kehadiran::where('guru_id', $guru->id)->where('tanggal', $today)->first();

        $base64Image = preg_replace('#^data:image/\w+;base64,#i', '', $request->photo_base64);
        $fileName = 'absensi/' . Str::uuid() . '.png';
        Storage::disk('public')->put($fileName, base64_decode($base64Image));

        // ===== ABSEN MASUK =====
        if ($modeAbsen === 'masuk') {
            if ($absenHariIni) {
                return back()->with('error', 'Kamu sudah absen masuk hari ini ❌');
            }

            $jamSekarang = now()->format('H:i');
            $status = $jamSekarang <= $jam->batas_terlambat ? 'tepat_waktu' : 'terlambat';

            Absensi::create([
                'uuid' => Str::uuid(),
                'guru_id' => $guru->id,
                'photo' => $fileName,
                'latitude' => $request->latitude,
                'longitude' => $request->longitude,
                'status' => $status,
            ]);

            $waktu = Waktu::first();

            Kehadiran::create([
                'guru_id' => $guru->id,
                'tanggal' => $today,
                'jam_masuk' => now()->format('H:i:s'),
                'jam_mulai_masuk' => $waktu->mulai_tap_in,
                'jam_mulai_pulang' => $waktu->mulai_tap_out,
                'jam_akhir_pulang' => $waktu->akhir_tap_out,
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

            $jamPulang = now();

            $batasCepat = Carbon::parse($today . ' ' . ($jam->mulai_tap_out));
            $batasLembur = Carbon::parse($today . ' ' . ($jam->akhir_tap_out));

            $statusPulang = 'tepat_waktu';
            $lemburMenit = 0;
            $selisihPulangCepat = 0;

            if ($jamPulang->gt($batasLembur)) {
                $statusPulang = 'lembur';
                $lemburMenit = (int)($jamPulang->diffInMinutes($batasLembur));
            } elseif ($jamPulang->lt($batasCepat)) {
                $statusPulang = 'pulang_cepat';
                $selisihPulangCepat = (int)($jamPulang->diffInMinutes($batasCepat));
            }
    
            $absenHariIni->update([
                'photo_pulang' => $fileName,
                'latitude_pulang' => $request->latitude,
                'longitude_pulang' => $request->longitude,
                'status_pulang' => $statusPulang,
                'lembur_menit' => $lemburMenit,
                'selisih_pulang_cepat' => $selisihPulangCepat,
            ]);

            if ($kehadiranHariIni) {
                $kehadiranHariIni->update([
                    'jam_pulang' => now()->format('H:i:s'),
                    'lembur_menit' => $lemburMenit,
                ]);
            } else {
                Kehadiran::create([
                    'guru_id' => $guru->id,
                    'tanggal' => $today,
                    'jam_pulang' => now()->format('H:i:s'),
                    'lembur_menit' => $lemburMenit,
                    'jam_mulai_pulang' => $jam->mulai_tap_out,
                    'jam_akhir_pulang' => $jam->akhir_tap_out,
                ]);
            }

            if ($statusPulang === 'lembur') {
                $pesan = "Lembur {$lemburMenit} menit ⏰";
            } elseif ($statusPulang === 'pulang_cepat') {
                $pesan = "Pulang cepat {$selisihPulangCepat} menit lebih awal ⚠️";
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