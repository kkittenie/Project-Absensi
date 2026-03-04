<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Guru;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class GuruController extends Controller
{
    // =====================
    // INDEX
    // =====================
    public function index(Request $request)
    {
        $status = $request->get('status', 'active');

        $gurus = Guru::where('is_active', $status === 'active' ? 1 : 0)
            ->orderBy('nama_guru')
            ->get();

        return view('admin.guru.index', compact('gurus'));
    }

    // =====================
    // CREATE
    // =====================
    public function create()
    {
        return view('admin.guru.create');
    }

    // =====================
    // STORE (INI YANG FIX!)
    // =====================
    public function store(Request $request)
    {
        $request->validate([
            'nama_guru'      => 'required|string|max:255',
            'mata_pelajaran' => 'required|string|max:255',
            'nip'            => 'required|string|max:50',
            'nomor_telepon'  => 'required|string|max:20',
            'is_active'      => 'required|boolean',
        ]);

        Guru::create([
            'uuid'           => Str::uuid(),
            'nama_guru'      => $request->nama_guru,
            'mata_pelajaran' => $request->mata_pelajaran,
            'nip'            => $request->nip,
            'nomor_telepon'  => $request->nomor_telepon,
            'is_active'      => $request->is_active, // 🔥 WAJIB
            'role'           => 'guru',
            'password'       => Hash::make('password123'),
        ]);

        return redirect()
            ->route('admin.guru.index', ['status' => 'active'])
            ->with('success', 'Guru berhasil ditambahkan');
    }
}
