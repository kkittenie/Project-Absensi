<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;


class GuruController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->get('status', 'active');

        if ($status === 'inactive') {
            $gurus = Guru::where('is_active', false)->get();
        } else {
            $gurus = Guru::where('is_active', true)->get();
        }

        return view('guru.index', compact('gurus', 'status'));
    }


    public function create()
    {
        return view('guru.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_guru' => 'required',
            'mata_pelajaran' => 'required',
            'nip' => 'required|unique:gurus,nip',
            'nomor_telepon' => 'required',
            'photo' => 'nullable|image|max:2048'
        ]);

        $data = $request->all();
        $data['uuid'] = Str::uuid();
        $data['is_active'] = true;

        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('guru', 'public');
        }

        Guru::create($data);

        return redirect()->route('admin.guru.index');
    }


    public function edit($uuid)
    {
        $guru = Guru::where('uuid', $uuid)->firstOrFail();

        return view('guru.edit', compact('guru'));
    }

    public function update(Request $request, $uuid)
    {
        $guru = Guru::where('uuid', $uuid)->firstOrFail();

        $request->validate([
            'nama_guru' => 'required',
            'mata_pelajaran' => 'required',
            'nip' => [
                'required',
                Rule::unique('gurus', 'nip')->ignore($guru->id),
            ],
            'nomor_telepon' => 'required',
            'photo' => 'nullable|image|max:2048',
        ]);

        $data = $request->all();

        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('guru', 'public');
        }

        $guru->update($data);

        return redirect()->route('admin.guru.index');
    }


    public function remove($uuid)
    {
        $guru = Guru::where('uuid', $uuid)->firstOrFail();
        $guru->delete();

        return redirect()->route('admin.guru.index');
    }
    public function activate($uuid)
    {
        $guru = Guru::where('uuid', $uuid)->firstOrFail();

        $guru->update([
            'is_active' => true
        ]);

        return redirect()->route('admin.guru.index')
            ->with('success', 'Guru berhasil diaktifkan kembali');
    }

    public function deactivate($uuid)
    {
        $guru = Guru::where('uuid', $uuid)->firstOrFail();

        $guru->update([
            'is_active' => false
        ]);

        return redirect()->route('admin.guru.index')
            ->with('success', 'Guru berhasil dinonaktifkan');
    }
}
