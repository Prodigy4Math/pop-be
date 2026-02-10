<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class PesertaMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (auth('peserta')->check() && auth('peserta')->user()->isPeserta()) {
            if (auth('admin')->check()) {
                Auth::guard('admin')->logout();
            }
            return $next($request);
        }

        if (auth('admin')->check()) {
            return redirect()->route('admin.dashboard')->with('error', 'Anda login sebagai admin.');
        }

        return redirect('/login')->with('error', 'Unauthorized access');
    }
}
