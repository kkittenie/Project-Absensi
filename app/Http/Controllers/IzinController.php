<?php

namespace App\Http\Controllers;

use App\Models\Izin;
use App\Models\Kehadiran;
use App\Models\HariLibur;
use App\Models\Waktu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class IzinController extends Controller
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
        $namaHari = $carbon->locale('id')->isoFormat('dddd'); // Senin, Selasa, dst

        if (in_array($namaHari, $jam->hari_libur_mingguan ?? [])) {
            return true;
        }

        return HariLibur::where('tanggal', $tanggal)->exists();
    }

    public function index()
    {
        $guru = Auth::guard('guru')->user();

        $izins = Izin::where('guru_id', $guru->id)
            ->orderBy('tanggal_izin', 'desc')
            ->get();

        return view('izin.index', compact('izins'));
    }

    public function create()
    {
        $today = now()->toDateString();
        $jam = $this->getJam();
        $isLibur = $this->isHariLibur($today);

        return view('izin.create', compact('isLibur', 'jam'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'jenis_izin' => 'required|in:sakit,izin,lainnya',
            'tanggal_izin' => 'required|date',
            'alasan' => 'nullable|string',
            'foto_surat' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $guru = Auth::guard('guru')->user();
        $tanggal = $request->tanggal_izin;

        if ($this->isHariLibur($tanggal)) {
            return back()->with('error', 'Hari libur tidak bisa mengajukan izin ❌');
        }

        $sudahIzin = Izin::where('guru_id', $guru->id)
            ->whereDate('tanggal_izin', $tanggal)
            ->exists();

        if ($sudahIzin) {
            return back()->with('error', 'Kamu sudah mengajukan izin untuk tanggal tersebut.');
        }

        $sudahAbsenLengkap = Kehadiran::where('guru_id', $guru->id)
            ->whereDate('tanggal', $tanggal)
            ->whereNotNull('jam_masuk')
            ->whereNotNull('jam_pulang')
            ->exists();

        if ($sudahAbsenLengkap) {
            return back()->with('error', 'Tidak bisa izin, kamu sudah absen lengkap.');
        }

        $foto = null;
        if ($request->hasFile('foto_surat')) {
            $foto = $request->file('foto_surat')
                ->store('izin_guru', 'public');
        }

        Izin::create([
            'guru_id' => $guru->id,
            'jenis_izin' => $request->jenis_izin,
            'alasan' => $request->alasan,
            'foto_surat' => $foto,
            'tanggal_izin' => $tanggal,
            'status' => 'menunggu',
        ]);

        return redirect()
            ->route('guru.izin.index')
            ->with('success', 'Pengajuan izin berhasil dikirim');
    }
}