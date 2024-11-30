<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    /**
     * Maneja una solicitud entrante.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $role
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $role)
    {
        // Verificar si el usuario está autenticado
        if (!Auth::check()) {
            return redirect('login'); // Redirige al login si no está autenticado
        }

        // Verificar si el rol del usuario coincide con el esperado
        if (Auth::user()->role !== $role) {
            abort(403, 'Unauthorized'); // Retorna error 403 si el rol no coincide
        }

        return $next($request);
    }
}
