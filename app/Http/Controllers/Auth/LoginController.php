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

        // Rate Limiting
        if (RateLimiter::tooManyAttempts($key, 5)) {
            $seconds = RateLimiter::availableIn($key);
            return back()->withErrors([
                'nip' => "Terlalu banyak percobaan. Coba lagi dalam $seconds detik."
            ]);
        }

        RateLimiter::hit($key, 60);

        // Cek User (Admin/Superadmin)
        $user = User::where('nip', $nip)->where('is_active', true)->first();

        if ($user && Hash::check($password, $user->password)) {
            Auth::guard('web')->login($user, $remember);
            
            RateLimiter::clear($key);
            
            $request->session()->regenerate();

            return redirect()->route('admin.dashboard')
                ->with('success', "Selamat datang, {$user->name}!");
        }

        // Cek Guru
        $guru = Guru::where('nip', $nip)->where('is_active', true)->first();

        if ($guru && Hash::check($password, $guru->password)) {
            Auth::guard('guru')->login($guru, $remember);
            
            RateLimiter::clear($key);
            
            $request->session()->regenerate();

            return redirect()->route('landing.index')
                ->with('success', "Selamat datang, {$guru->nama_guru}!");
        }
        
        return back()->withErrors([
            'nip' => 'NIP atau password salah, atau akun tidak aktif.',
        ])->withInput($request->only('nip'));
    }
    
    public function loginGuru(Request $request)
    {
        $request->validate([
            'nip' => 'required',
            'password' => 'required',
        ]);

        $credentials = [
            'nip' => $request->nip,
            'password' => $request->password,
            'is_active' => 1,
        ];

        if (Auth::guard('guru')->attempt($credentials)) {
            $request->session()->regenerate();
            
            $guru = Auth::guard('guru')->user();
            
            return redirect()->route('guru.dashboard')
                ->with('success', "Selamat datang, {$guru->nama_guru}!");
        }

        return back()->withErrors([
            'nip' => 'NIP atau password salah',
        ])->withInput($request->only('nip'));
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