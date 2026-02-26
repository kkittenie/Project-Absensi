<?php

namespace App\Http\Controllers;

use App\Models\Izin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IzinController extends Controller
{
    /**
     * Tampilkan histori izin guru login
     */
    public function index()
    {
        $guru = Auth::guard('guru')->user();

        $izins = Izin::where('guru_id', $guru->id)
            ->orderBy('tanggal_izin', 'desc')
            ->get();

        return view('izin.index', compact('izins'));
    }

    /**
     * Form pengajuan izin
     */
    public function create()
    {
        return view('izin.create');
    }

    /**
     * Simpan pengajuan izin
     */
    public function store(Request $request)
    {
        $request->validate([
            'jenis_izin' => 'required|in:sakit,izin,lainnya',
            'tanggal_izin' => 'required|date',
            'alasan' => 'nullable|string',
            'foto_surat' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $guru = Auth::guard('guru')->user();

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
            'tanggal_izin' => $request->tanggal_izin,
            'status' => 'menunggu',
        ]);

        return redirect()
            ->route('guru.izin.index')
            ->with('success', 'Pengajuan izin berhasil dikirim');
    }
}
