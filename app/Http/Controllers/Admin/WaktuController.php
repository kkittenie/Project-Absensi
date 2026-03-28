<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Waktu;
use Carbon\Carbon;
use Illuminate\Http\Request;

class WaktuController extends Controller
{
    // Tampilkan halaman pengaturan jam
    public function index()
    {
        $jam = Waktu::first();

        // jika belum ada, buat default
        if (!$jam) {
            $jam = Waktu::create([
                'guru_id' => 5, // pastikan guru dengan ID 1 ada
                'tanggal' => Carbon::today(),
                'mulai_tap_in' => '06:00',
                'akhir_tap_in' => '11:00',
                'batas_terlambat' => '07:00',
                'mulai_tap_out' => '14:00',
                'akhir_tap_out' => '18:00',
               
            ]);
        }

        return view('admin.waktu.index', compact('jam'));
    }

    // Update jam kehadiran
    public function update(Request $request, $id)
    {
        $request->validate([
            'mulai_tap_in' => 'required',
            'akhir_tap_in' => 'required',
            'batas_terlambat' => 'required',
            'mulai_tap_out' => 'required',
            'akhir_tap_out' => 'required',
           
        ]);

        $jam = Waktu::findOrFail($id);
        $jam->update([
            'mulai_tap_in' => $request->mulai_tap_in,
            'akhir_tap_in' => $request->akhir_tap_in,
            'batas_terlambat' => $request->batas_terlambat,
            'mulai_tap_out' => $request->mulai_tap_out,
            'akhir_tap_out' => $request->akhir_tap_out,
          
        ]);

      return redirect()->route('admin.jam_kehadiran.index')->with('success', 'Jam kehadiran berhasil diupdate.');
    }
}