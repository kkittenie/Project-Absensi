<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Waktu;
use App\Models\HariLibur;
use Illuminate\Http\Request;

class WaktuController extends Controller
{
    public function index()
    {
        $jam = Waktu::first();

        if (!$jam) {
            $jam = Waktu::create([
                'mulai_tap_in'        => '06:00',
                'akhir_tap_in'        => '09:00',
                'batas_terlambat'     => '07:00',
                'mulai_tap_out'       => '13:00',
                'akhir_tap_out'       => '15:00',
                'hari_libur_mingguan' => ['Sabtu', 'Minggu'],
            ]);
        }

        $hariLiburs = HariLibur::orderBy('tanggal')->get();

        return view('admin.waktu.index', compact('jam', 'hariLiburs'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'mulai_tap_in'        => 'required',
            'akhir_tap_in'        => 'required',
            'batas_terlambat'     => 'required',
            'mulai_tap_out'       => 'required',
            'akhir_tap_out'       => 'required',
            'hari_libur_mingguan' => 'nullable|array',
        ]);

        $jam = Waktu::findOrFail($id);
        $jam->update([
            'mulai_tap_in'        => $request->mulai_tap_in,
            'akhir_tap_in'        => $request->akhir_tap_in,
            'batas_terlambat'     => $request->batas_terlambat,
            'mulai_tap_out'       => $request->mulai_tap_out,
            'akhir_tap_out'       => $request->akhir_tap_out,
            'hari_libur_mingguan' => $request->hari_libur_mingguan ?? [],
        ]);

        return redirect()->route('admin.jam_kehadiran.index')
            ->with('success', 'Pengaturan jam berhasil disimpan.');
    }

    public function tambahLibur(Request $request)
    {
        $request->validate([
            'tanggal'     => 'required|date|unique:hari_liburs,tanggal',
            'keterangan'  => 'nullable|string|max:255',
        ], [
            'tanggal.unique' => 'Tanggal ini sudah terdaftar sebagai hari libur.',
        ]);

        HariLibur::create([
            'tanggal'    => $request->tanggal,
            'keterangan' => $request->keterangan,
        ]);

        return redirect()->route('admin.jam_kehadiran.index')
            ->with('success', 'Hari libur berhasil ditambahkan.');
    }

    public function hapusLibur($id)
    {
        HariLibur::findOrFail($id)->delete();

        return redirect()->route('admin.jam_kehadiran.index')
            ->with('success', 'Hari libur berhasil dihapus.');
    }
}