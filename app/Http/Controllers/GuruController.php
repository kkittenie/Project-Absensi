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

    public function create()
    {
        $mapels = Mapel::all();
        return view('admin.guru.create', compact('mapels'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_guru'     => 'required|string|max:255',
            'email'         => 'required|email|unique:gurus,email',
            'mapel_id'      => 'required|exists:mapels,id',
            'nip'           => 'required|string|unique:gurus,nip',
            'nomor_telepon' => 'required|string|max:20',
            'photo'         => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ], [
            'nama_guru.required'     => 'Nama guru wajib diisi.',
            'email.required'         => 'Email wajib diisi.',
            'email.email'            => 'Format email tidak valid.',
            'email.unique'           => 'Email sudah digunakan.',
            'mapel_id.required'      => 'Mapel wajib dipilih.',
            'mapel_id.exists'        => 'Mapel tidak valid.',
            'nip.required'           => 'NIP wajib diisi.',
            'nip.unique'             => 'NIP sudah digunakan.',
            'nomor_telepon.required' => 'Nomor telepon wajib diisi.',
        ]);

        $data = [
            'uuid'          => Str::uuid(),
            'nama_guru'     => $request->nama_guru,
            'email'         => $request->email,
            'mapel_id'      => $request->mapel_id,
            'nip'           => $request->nip,
            'nomor_telepon' => $request->nomor_telepon,
            'is_active'     => true,
            'role'          => 'guru',
            'password'      => Hash::make('password123'),
        ];

        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('guru', 'public');
        }

        Guru::create($data);

        return redirect()
            ->route('admin.guru.index', ['status' => 'active'])
            ->with('success', 'Guru berhasil ditambahkan');
    }

    public function edit($uuid)
    {
        $guru   = Guru::where('uuid', $uuid)->firstOrFail();
        $mapels = Mapel::all();

        return view('admin.guru.edit', compact('guru', 'mapels'));
    }

    public function update(Request $request, $uuid)
    {
        $guru = Guru::where('uuid', $uuid)->firstOrFail();

        $request->validate([
            'nama_guru'     => 'required|string|max:255',
            'email'         => 'required|email|unique:gurus,email,' . $guru->id,
            'mapel_id'      => 'required|exists:mapels,id',
            'nip'           => [
                'required', 'string',
                Rule::unique('gurus', 'nip')->ignore($guru->id),
            ],
            'nomor_telepon' => 'required|string|max:20',
            'photo'         => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $data = $request->only([
            'nama_guru', 'email', 'mapel_id', 'nip', 'nomor_telepon'
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
    }

    public function resetPassword($uuid)
    {
        $guru = Guru::where('uuid', $uuid)->firstOrFail();
        $guru->update([
            'password' => Hash::make($guru->nip)
        ]);

        return back()->with('success', 'Password guru berhasil direset ke NIP.');
    }
}