<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SessionNamespaceMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        $namespace = $request->query('session');

        if (is_string($namespace) && preg_match('/^[a-z0-9_-]{1,32}$/i', $namespace)) {
            config(['session.cookie' => 'popbe_' . $namespace]);
        }

        return $next($request);
    }
}
