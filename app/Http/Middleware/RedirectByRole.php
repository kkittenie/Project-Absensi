<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RedirectByRole
{
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check()) {

            if (auth()->user()->hasRole('user')) {
                return redirect()->route('landing.index');
            }

            if (auth()->user()->hasRole(['admin', 'superadmin'])) {
                return redirect()->route('admin.dashboard');
            }
        }

        return $next($request);
    }
}
