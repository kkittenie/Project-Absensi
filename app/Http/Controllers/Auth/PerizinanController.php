<?php

namespace App\Http\Controllers;

use App\Models\Izin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PerizinanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $izins = Izin::with('guru')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('perizinan.index', compact('izins'));
    }

     // Setujui
    public function approve($id)
    {
        $izin = Izin::findOrFail($id);
        $izin->update(['status' => 'disetujui']);

        return back()->with('success', 'Izin disetujui');
    }

    // Tolak
    public function reject($id)
    {
        $izin = Izin::findOrFail($id);
        $izin->update(['status' => 'ditolak']);

        return back()->with('success', 'Izin ditolak');
    }

    public function surat(Izin $izin)
    {
    return view('perizinan.surat', compact('izin'));
    }

    /**
     * Show the form for creating a new resource.
     */
    // public function create()
    // {
    //     //
    // }

    /**
     * Store a newly created resource in storage.
     */
    // public function store(Request $request)
    // {
    //     //
    // }

    /**
     * Display the specified resource.
     */
    // public function show(Perizinan $perizinan)
    // {
    //     //
    // }

    /**
     * Show the form for editing the specified resource.
     */
    // public function edit(Perizinan $perizinan)
    // {
    //     //
    // }

    /**
     * Update the specified resource in storage.
     */
    // public function update(Request $request, Perizinan $perizinan)
    // {
    //     //
    // }

    /**
     * Remove the specified resource from storage.
     */
    // public function destroy(Perizinan $perizinan)
    // {
    //     //
    // }
}
