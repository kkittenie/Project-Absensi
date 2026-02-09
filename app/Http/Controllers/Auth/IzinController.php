<?php

namespace App\Http\Controllers;

use App\Models\Izin;
use App\Models\Guru;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class IzinController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $gurus = Guru::all();

        $izins = collect();

        if ($request->guru_id) {
            $izins = Izin::with('guru')
                ->where('guru_id', $request->guru_id)
                ->orderBy('tanggal_izin', 'desc')
                ->get();
        }

        return view('izin.index', compact('gurus', 'izins'));
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $gurus = Guru::all(); 
        return view('izin.create', compact('gurus'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
         $request->validate([
            'guru_id' => 'required|exists:gurus,id',
            'jenis_izin' => 'required',
            'tanggal_izin' => 'required|date',
            'foto_surat' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        $foto = null;
        if ($request->hasFile('foto_surat')) {
            $foto = $request->file('foto_surat')->store('izin_guru', 'public');
        }

       Izin::create([
            'guru_id' => $request->guru_id,
            'jenis_izin' => $request->jenis_izin,
            'alasan' => $request->alasan,
            'foto_surat' => $foto,
            'tanggal_izin' => $request->tanggal_izin,
            'status' => 'menunggu'
        ]);


        return redirect()->back()->with('success', 'Izin guru berhasil dikirim');
    }

    /**
     * Display the specified resource.
     */
    // public function show(Izin $izin)
    // {
    //     //
    // }

    /**
     * Show the form for editing the specified resource.
     */
    // public function edit(Izin $izin)
    // {
    //     //
    // }

    /**
     * Update the specified resource in storage.
     */
    // public function update(Request $request, Izin $izin)
    // {
    //     //
    // }

    /**
     * Remove the specified resource from storage.
     */
//     public function destroy(Izin $izin)
//     {
//         //
//     }
// }
}