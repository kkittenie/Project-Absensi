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
    // Tampilkan halaman login
    public function index()
    {
        return view('auth.login');
    }

    // Proses login
    public function store(Request $request)
    {
        $request->validate([
            'nip' => 'required|max:255',
            'password' => 'required|max:255',
        ], [
            'nip.required' => 'NIP harus diisi!',
            'nip.max' => 'NIP maksimal 255 karakter!',
            'password.required' => 'Password harus diisi!',
            'password.max' => 'Password maksimal 255 karakter!',
        ]);

        $nip = $request->nip;
        $password = $request->password;
        $remember = $request->boolean('remember');

        $key = Str::lower($nip) . '|' . $request->ip();

        if (RateLimiter::tooManyAttempts($key, 5)) {
            $seconds = RateLimiter::availableIn($key);
            return back()->withErrors("Terlalu banyak percobaan. Coba lagi dalam $seconds detik.");
        }

        RateLimiter::hit($key, 60);

        $user = User::where('nip', $nip)->where('is_active', true)->first();

        if ($user && Hash::check($password, $user->password)) {
            Auth::guard('web')->login($user, $remember);

            return redirect()->route('admin.dashboard')
                ->withSuccess("Selamat datang, {$user->name}");
        }

        $guru = Guru::where('nip', $nip)->where('is_active', true)->first();

        if ($guru && Hash::check($password, $guru->password)) {
            Auth::guard('guru')->login($guru, $remember);

            return redirect()->route('absensi.index')
                ->withSuccess("Selamat datang, {$guru->nama_guru}");
        }
        return back()->withErrors([
            'nip' => 'NIP atau password salah, atau akun tidak aktif.',
        ]);
    }

    // Logout
    public function logout(Request $request)
    {
        // Logout pakai guard yang sesuai
        if (Auth::guard('guru')->check()) {
            Auth::guard('guru')->logout();
        } else {
            Auth::logout();
        }

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->withSuccess('Logout Berhasil!');
    }
}
