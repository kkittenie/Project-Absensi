<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Guru;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;

class LoginController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }

    public function store(Request $request)
    {
        $request->validate([
            'identifier' => 'required|max:255',
            'password' => 'required|max:255',
        ], [
            'identifier.required' => 'Username atau NIP harus diisi!',
            'password.required' => 'Password harus diisi!',
        ]);

        $identifier = $request->identifier;
        $password = $request->password;
        $remember = $request->boolean('remember');

        $key = Str::lower($identifier) . '|' . $request->ip();

        // Rate Limiting
        if (RateLimiter::tooManyAttempts($key, 5)) {
            $seconds = RateLimiter::availableIn($key);
            return back()->withErrors([
                'identifier' => "Terlalu banyak percobaan. Coba lagi dalam $seconds detik."
            ]);
        }

        RateLimiter::hit($key, 60);

        $user = User::where('username', $identifier)->where('is_active', true)->first();

        if ($user && Hash::check($password, $user->password)) {
            Auth::guard('web')->login($user, $remember);

            RateLimiter::clear($key);

            $request->session()->regenerate();

            return redirect()->route('admin.dashboard')
                ->with('success', "Selamat datang, {$user->name}!");
        }

        $guru = Guru::where('nip', $identifier)->where('is_active', true)->first();

        if ($guru && Hash::check($password, $guru->password)) {
            Auth::guard('guru')->login($guru, $remember);

            RateLimiter::clear($key);

            $request->session()->regenerate();

            return redirect()->route('guru.absensi.index')
                ->withSuccess("Selamat datang, {$guru->nama_guru}");
        }

        return back()->withErrors([
            'identifier' => 'Username/NIP atau password salah, atau akun tidak aktif.',
        ])->withInput($request->only('identifier'));
    }

    public function logout(Request $request)
    {
        $nama = null;

        if (Auth::guard('guru')->check()) {
            $nama = Auth::guard('guru')->user()->nama_guru;
            Auth::guard('guru')->logout();
        } elseif (Auth::check()) {
            $nama = Auth::user()->name;
            Auth::logout();
        }

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')
            ->with('success', $nama ? "Sampai jumpa, {$nama}!" : 'Logout berhasil!');
    }
}