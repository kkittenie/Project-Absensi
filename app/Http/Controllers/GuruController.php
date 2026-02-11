<?php

namespace App\Http\Controllers;

use App\Models\Guru;
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
            $gurus = Guru::where('is_active', false)->get();
        } else {
            $gurus = Guru::where('is_active', true)->whereNull('deleted_at')->get();
        }

        return view('admin.guru.index', compact('gurus', 'status'));
    }

    public function create()
    {
        return view('admin.guru.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_guru' => 'required|string|max:255',
            'mata_pelajaran' => 'required|string|max:255',
            'nip' => 'required|string|unique:gurus,nip',
            'nomor_telepon' => 'required|string|max:20',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ], [
            'nama_guru.required' => 'Nama guru wajib diisi.',
            'mata_pelajaran.required' => 'Mata pelajaran wajib diisi.',
            'nip.required' => 'NIP wajib diisi.',
            'nip.unique' => 'NIP sudah digunakan.',
            'nomor_telepon.required' => 'Nomor telepon wajib diisi.',
            'photo.image' => 'Foto wajib berupa gambar.',
            'photo.mimes' => 'Format foto harus JPG, JPEG, PNG, atau WEBP.',
            'photo.max' => 'Ukuran foto maksimal 2MB.',
        ]);

        $data = $request->only(['nama_guru', 'mata_pelajaran', 'nip', 'nomor_telepon']);
        $data['uuid'] = Str::uuid();
        $data['password'] = Hash::make($request->nip); // default password NIP
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
        return view('admin.guru.edit', compact('guru'));
    }

    public function update(Request $request, $uuid)
    {
        $guru = Guru::where('uuid', $uuid)->firstOrFail();

        $request->validate([
            'nama_guru' => 'required|string|max:255',
            'mata_pelajaran' => 'required|string|max:255',
            'nip' => [
                'required',
                'string',
                Rule::unique('gurus', 'nip')->ignore($guru->id),
            ],
            'nomor_telepon' => 'required|string|max:20',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $data = $request->only(['nama_guru', 'mata_pelajaran', 'nip', 'nomor_telepon']);

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
}
