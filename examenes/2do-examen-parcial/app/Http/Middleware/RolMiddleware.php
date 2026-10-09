<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RolMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        $user = $request->user();

        if (! $user) {
            return redirect()->route('login')->with('error', 'Debes iniciar sesión para continuar.');
        }

        if (! in_array($user->role, $roles, true)) {
            return redirect()->route('torneos.index')->with('error', 'No tienes permiso para acceder a esa sección.');
        }

        return $next($request);
    }
}
