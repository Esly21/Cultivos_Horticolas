<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class IsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        dd('Middleware cargado:', Auth::user()->id_tipo_usuario);

        if (!Auth::check() || Auth::user()->id_tipo_usuario != 1) {
            abort(403, 'Acceso no autorizado.');
        }
        return $next($request);

    }
}
