<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Guru;
use App\Models\Mapel;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;

class GuruController extends Controller
{
    // =====================
    // INDEX
    // =====================
    public function index(Request $request)
    {
        $status = $request->get('status', 'active');

        if ($status === 'inactive') {
            $gurus = Guru::with('mapel')
                ->where('is_active', false)
                ->orderBy('nama_guru')
                ->get();
        } else {
            $gurus = Guru::with('mapel')
                ->where('is_active', true)
                ->orderBy('nama_guru')
                ->get();
        }

        return view('admin.guru.index', compact('gurus'));
    }

    // =====================
    // CREATE
    // =====================
    public function create()
    {
        $mapels = Mapel::all();
        return view('admin.guru.create', compact('mapels'));
    }

    // =====================
    // STORE
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
            'is_active'      => $request->is_active,
            'role'           => 'guru',
            'password'       => Hash::make('password123'),
        ]);

        return redirect()
            ->route('admin.guru.index', ['status' => 'active'])
            ->with('success', 'Guru berhasil ditambahkan');
    }

    // =====================
    // EDIT
    // =====================
    public function edit($uuid)
    {
        $guru = Guru::where('uuid', $uuid)->firstOrFail();
        $mapels = Mapel::all();

        return view('admin.guru.edit', compact('guru', 'mapels'));
    }

    // =====================
    // UPDATE
    // =====================
    public function update(Request $request, $uuid)
    {
        $guru = Guru::where('uuid', $uuid)->firstOrFail();

        $request->validate([
            'nama_guru' => 'required|string|max:255',
            'email' => 'required|email|unique:gurus,email,' . $guru->id,
            'mapel_id' => 'required|exists:mapels,id',
            'nip' => [
                'required',
                'string',
                Rule::unique('gurus', 'nip')->ignore($guru->id),
            ],
            'nomor_telepon' => 'required|string|max:20',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $data = $request->only([
            'nama_guru',
            'email',
            'mapel_id',
            'nip',
            'nomor_telepon'
        ]);

        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('guru', 'public');
        }

        $guru->update($data);

        return redirect()->route('admin.guru.index')
            ->with('success', 'Data guru berhasil diperbarui.');
    }

    // =====================
    // DELETE
    // =====================
    public function remove($uuid)
    {
        $guru = Guru::where('uuid', $uuid)->firstOrFail();
        $guru->delete();

        return redirect()->route('admin.guru.index')
            ->with('success', 'Guru berhasil dihapus.');
    }

    // =====================
    // ACTIVATE
    // =====================
    public function activate($uuid)
    {
        $guru = Guru::where('uuid', $uuid)->firstOrFail();
        $guru->update(['is_active' => true]);

        return redirect()->route('admin.guru.index')
            ->with('success', 'Guru berhasil diaktifkan kembali.');
    }

    // =====================
    // DEACTIVATE
    // =====================
    public function deactivate($uuid)
    {
        $guru = Guru::where('uuid', $uuid)->firstOrFail();
        $guru->update(['is_active' => false]);

        return redirect()->route('admin.guru.index')
            ->with('success', 'Guru berhasil dinonaktifkan.');
    }
}