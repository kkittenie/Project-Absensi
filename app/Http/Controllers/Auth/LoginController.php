<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
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
            'username' => 'required',
            'max:255',
            'password' => 'required',
            'max:255',
        ], [
            'username.required' => 'Username harus diisi!',
            'username.max' => 'Username maksimal 255 karakter!',
            'password.required' => 'Password harus diisi!',
            'password.max' => 'Password maksimal 255 karakter!',
        ]);

        $key = Str::lower($request->username) . '|' . $request->ip();

        if (RateLimiter::tooManyAttempts($key, 5)) {
            $seconds = RateLimiter::availableIn($key);
            return back()->withErrors("Terlalu banyak percobaan. Coba lagi dalam $seconds detik.");
        }

        RateLimiter::hit($key, 60);

        $user = User::where('username', $request->username)
            ->where('is_active', true)
            ->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return back()->withErrors('Username atau password salah!');
        }

        RateLimiter::clear($key);

        $remember = $request->boolean('remember');
        Auth::login($user, $remember);

        return redirect()->route('admin.dashboard')
            ->withSuccess("Selamat datang, {$user->name}!");
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->withSuccess('Logout Berhasil!');
    }
}
