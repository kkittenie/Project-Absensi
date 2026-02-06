<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->get('status', 'active');

        $users = User::when($status === 'inactive', function ($q) {
            $q->where('is_active', false);
        }, function ($q) {
            $q->where('is_active', true);
        })
            ->latest()
            ->get();

        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username',
            'password' => 'required|string|min:6|confirmed',
            'role' => 'required|in:superadmin,admin,user',
            'is_active' => 'required|boolean',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ], [
            'name.required' => 'Nama wajib diisi.',
            'username.required' => 'Username wajib diisi.',
            'username.unique' => 'Username sudah digunakan.',
            'password.required' => 'Password wajib diisi.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'role.required' => 'Role wajib dipilih.',
            'photo.image' => 'Foto wajib berupa gambar!',
            'photo.mimes' => 'Format foto wajib sesuai dengan yang ditentukan!',
            'photo.max' => 'Ukuran foto maksimal 2MB!'
        ]);

        $photoPath = null;

        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')
                ->store('users', 'public');
        }

        $user = User::create([
            'uuid' => Str::uuid(),
            'name' => $request->name,
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'is_active' => $request->is_active,
            'photo' => $photoPath,
        ]);

        $user->syncRoles([$request->role]);

        if ($user->hasRole('superadmin') || $user->hasRole('admin')) {
            return redirect()->route('admin.dashboard');
        }

        return redirect()->route('landing.index');
    }

    public function edit(string $uuid)
    {
        $user = User::where('uuid', $uuid)->firstOrFail();

        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, string $uuid)
    {
        $user = User::where('uuid', $uuid)->firstOrFail();

        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username,' . $user->id,
            'password' => 'nullable|string|min:6|confirmed',
            'role' => 'required|in:superadmin,admin',
            'is_active' => 'required|boolean',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ], [
            'name.required' => 'Nama wajib diisi.',
            'username.required' => 'Username wajib diisi.',
            'username.unique' => 'Username sudah digunakan.',
            'password.required' => 'Password wajib diisi.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'role.required' => 'Role wajib dipilih.',
            'photo.image' => 'Foto wajib berupa gambar!',
            'photo.mimes' => 'Format foto wajib sesuai dengan yang ditentukan!',
            'photo.max' => 'Ukuran foto maksimal 2MB!'
        ]);

        if ($request->hasFile('photo')) {
            if ($user->photo && Storage::disk('public')->exists($user->photo)) {
                Storage::disk('public')->delete($user->photo);
            }

            $user->photo = $request->file('photo')->store('users', 'public');
        }

        $user->update([
            'name' => $request->name,
            'username' => $request->username,
            'role' => $request->role,
            'is_active' => $request->is_active,
        ]);

        if ($request->filled('password')) {
            $user->update([
                'password' => Hash::make($request->password),
            ]);
        }

        $user->syncRoles([$request->role]);

        return redirect()
            ->route('admin.user.index')
            ->withSuccess('User berhasil diperbarui.');
    }

    public function remove(string $uuid)
    {
        $user = User::where('uuid', $uuid)->firstOrFail();

        if ($user->id === auth()->id()) {
            return back()->withError('Tidak bisa menghapus akun sendiri.');
        }

        if ($user->photo && Storage::disk('public')->exists($user->photo)) {
            Storage::disk('public')->delete($user->photo);
        }

        $user->syncRoles([]);

        $user->delete();

        return redirect()
            ->route('admin.user.index')
            ->withSuccess('User berhasil dihapus.');
    }

    public function activate(string $uuid)
    {
        $user = User::where('uuid', $uuid)->firstOrFail();

        $user->update([
            'is_active' => true,
        ]);

        return back()->withSuccess('User berhasil diaktifkan.');
    }

    public function deactivate(string $uuid)
    {
        $user = User::where('uuid', $uuid)->firstOrFail();

        if ($user->id === auth()->id()) {
            return back()->withError('Tidak bisa menonaktifkan akun sendiri.');
        }

        $user->update([
            'is_active' => false,
        ]);

        if (auth()->id() === $user->id) {
            auth()->logout();
        }

        return back()->withSuccess('User berhasil dinonaktifkan.');
    }
}
