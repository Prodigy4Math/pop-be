<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PesertaMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth('peserta')->check() || !auth('peserta')->user()->isPeserta()) {
            return redirect('/login')->with('error', 'Unauthorized access');
        }

        return $next($request);
    }
}
