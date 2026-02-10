<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleRedirectMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        $routeName = $request->route()?->getName();

        if (auth('admin')->check() && auth('admin')->user()?->isAdmin()) {
            if ($routeName && str_starts_with($routeName, 'peserta.')) {
                return redirect()->route('admin.dashboard');
            }
        }

        if (auth('peserta')->check() && auth('peserta')->user()?->isPeserta()) {
            if ($routeName && str_starts_with($routeName, 'admin.')) {
                return redirect()->route('peserta.dashboard');
            }
        }

        return $next($request);
    }
}
