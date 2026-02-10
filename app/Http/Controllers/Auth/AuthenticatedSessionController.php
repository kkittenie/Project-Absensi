<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(Request $request): RedirectResponse
    {
        // Validasi login NIP + password
        $credentials = $request->validate([
            'nip' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        // Coba login
        if (
            Auth::guard('guru')->attempt([
                'nip' => $request->nip,
                'password' => $request->password,
            ], $request->filled('remember'))
        ) {
            $request->session()->regenerate();

            // Redirect ke landing page setelah login
            $guru = Auth::guard('guru')->user();
            return redirect()->route('landing.index')
                ->withSuccess("Selamat datang, {$guru->nama_guru}!");
        }

        // Gagal login
        return back()->withErrors([
            'nip' => 'NIP atau password salah.',
        ]);
    }


    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
