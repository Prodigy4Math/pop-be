<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (auth('admin')->check() && auth('admin')->user()->isAdmin()) {
            if (auth('peserta')->check()) {
                Auth::guard('peserta')->logout();
            }
            return $next($request);
        }

        if (auth('peserta')->check()) {
            return redirect()->route('peserta.dashboard')->with('error', 'Anda login sebagai peserta.');
        }

        return redirect('/login')->with('error', 'Unauthorized access');
    }
}
