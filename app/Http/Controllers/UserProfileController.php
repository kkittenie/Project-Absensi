<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class UserProfileController extends Controller
{
    /**
     * Display profile page for Admin
     */
    public function indexAdmin()
    {
        return view('user-profile.index');
    }

    /**
     * Update profile for Admin
     */
    public function updateAdmin(Request $request)
    {
        // Validasi input
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username,' . auth()->id(),
            'photo' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048', // max 2MB
            'password' => 'nullable|string|min:8',
        ], [
            'name.required' => 'Nama harus diisi!',
            'username.required' => 'Username harus diisi!',
            'username.unique' => 'Username sudah digunakan!',
            'photo.image' => 'File harus berupa gambar!',
            'photo.mimes' => 'Format foto harus jpg, jpeg, png, atau webp!',
            'photo.max' => 'Ukuran foto maksimal 2MB!',
            'password.min' => 'Password minimal 8 karakter!',
        ]);

        $user = auth()->user();
        
        // Update nama dan username
        $user->name = $request->name;
        $user->username = $request->username;
        
        // Handle foto
        if ($request->hasFile('photo')) {
            // Hapus foto lama jika ada
            if ($user->photo && Storage::exists('public/' . $user->photo)) {
                Storage::delete('public/' . $user->photo);
            }
            
            // Upload foto baru
            $path = $request->file('photo')->store('photos', 'public');
            $user->photo = $path;
        }
        
        // Update password jika diisi
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }
        
        $user->save();
        
        return redirect()->back()->with('success', 'Profil berhasil diperbarui!');
    }

    /**
     * Display profile page for Guru
     */
    public function indexGuru()
    {
        return view('user-profile.index');
    }

    /**
     * Update profile for Guru
     */
    public function updateGuru(Request $request)
    {
        // Validasi input
        $request->validate([
            'nama_guru' => 'required|string|max:255',
            'email' => 'nullable|email|max:255|unique:gurus,email,' . auth('guru')->id(),
            'nomor_telepon' => 'nullable|string|max:20',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048', // max 2MB
            'password' => 'nullable|string|min:8',
        ], [
            'nama_guru.required' => 'Nama harus diisi!',
            'email.email' => 'Format email tidak valid!',
            'email.unique' => 'Email sudah digunakan!',
            'photo.image' => 'File harus berupa gambar!',
            'photo.mimes' => 'Format foto harus jpg, jpeg, png, atau webp!',
            'photo.max' => 'Ukuran foto maksimal 2MB!',
            'password.min' => 'Password minimal 8 karakter!',
        ]);

        $guru = auth('guru')->user();
        
        // Update data
        $guru->nama_guru = $request->nama_guru;
        $guru->email = $request->email;
        $guru->nomor_telepon = $request->nomor_telepon;
        
        // Handle foto
        if ($request->hasFile('photo')) {
            // Hapus foto lama jika ada
            if ($guru->photo && Storage::exists('public/' . $guru->photo)) {
                Storage::delete('public/' . $guru->photo);
            }
            
            // Upload foto baru
            $path = $request->file('photo')->store('photos', 'public');
            $guru->photo = $path;
        }
        
        // Update password jika diisi
        if ($request->filled('password')) {
            $guru->password = Hash::make($request->password);
        }
        
        $guru->save();
        
        return redirect()->back()->with('success', 'Profil berhasil diperbarui!');
    }
}