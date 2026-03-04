<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Guru;
<<<<<<< HEAD
use Illuminate\Http\Request;
use Illuminate\Support\Str;
=======
use App\Models\Mapel;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
>>>>>>> e089b05499cbd155a4be97c6a4336bffa879b434
use Illuminate\Support\Facades\Hash;

class GuruController extends Controller
{
    // =====================
    // INDEX
    // =====================
    public function index(Request $request)
    {
        $status = $request->get('status', 'active');

<<<<<<< HEAD
        $gurus = Guru::where('is_active', $status === 'active' ? 1 : 0)
            ->orderBy('nama_guru')
            ->get();
=======
        if ($status === 'inactive') {
            $gurus = Guru::with('mapel')
                ->where('is_active', false)
                ->get();
        } else {
            $gurus = Guru::with('mapel')
                ->when(request('status') === 'inactive', function ($q) {
                    $q->where('is_active', 0);
                }, function ($q) {
                    $q->where('is_active', 1);
                })
                ->get();
        }
>>>>>>> e089b05499cbd155a4be97c6a4336bffa879b434

        return view('admin.guru.index', compact('gurus'));
    }

<<<<<<< HEAD
    // =====================
    // CREATE
    // =====================
=======
>>>>>>> e089b05499cbd155a4be97c6a4336bffa879b434
    public function create()
    {
        $mapels = Mapel::all();
        return view('admin.guru.create', compact('mapels'));
    }

    // =====================
    // STORE (INI YANG FIX!)
    // =====================
    public function store(Request $request)
    {
        $request->validate([
<<<<<<< HEAD
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
=======
            'nama_guru' => 'required|string|max:255',
            'email' => 'required|email|unique:gurus,email',
            'mapel_id' => 'required|exists:mapels,id',
            'nip' => 'required|string|unique:gurus,nip',
            'nomor_telepon' => 'required|string|max:20',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ], [
            'nama_guru.required' => 'Nama guru wajib diisi.',
            'mapel_id.required' => 'Mapel wajib dipilih.',
            'mapel_id.exists' => 'Mapel tidak valid.',
            'nip.required' => 'NIP wajib diisi.',
            'nip.unique' => 'NIP sudah digunakan.',
            'nomor_telepon.required' => 'Nomor telepon wajib diisi.',
        ]);

        $data = $request->only([
            'nama_guru',
            'email',
            'mapel_id',
            'nip',
            'nomor_telepon'
        ]);

        $data['uuid'] = Str::uuid();
        $data['password'] = Hash::make($request->nip);
        $data['is_active'] = true;

        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('guru', 'public');
        }

        Guru::create($data);

        return redirect()->route('admin.guru.index')
            ->with('success', 'Guru berhasil ditambahkan.');
    }

    public function edit($uuid)
    {
        $guru = Guru::where('uuid', $uuid)->firstOrFail();
        $mapels = Mapel::all();

        return view('admin.guru.edit', compact('guru', 'mapels'));
    }

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

    public function remove($uuid)
    {
        $guru = Guru::where('uuid', $uuid)->firstOrFail();
        $guru->delete();

        return redirect()->route('admin.guru.index')
            ->with('success', 'Guru berhasil dihapus.');
    }

    public function activate($uuid)
    {
        $guru = Guru::where('uuid', $uuid)->firstOrFail();
        $guru->update(['is_active' => true]);

        return redirect()->route('admin.guru.index')
            ->with('success', 'Guru berhasil diaktifkan kembali.');
    }

    public function deactivate($uuid)
    {
        $guru = Guru::where('uuid', $uuid)->firstOrFail();
        $guru->update(['is_active' => false]);

        return redirect()->route('admin.guru.index')
            ->with('success', 'Guru berhasil dinonaktifkan.');
>>>>>>> e089b05499cbd155a4be97c6a4336bffa879b434
    }
}
