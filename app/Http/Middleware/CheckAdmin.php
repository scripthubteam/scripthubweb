<?php

namespace App\Http\Middleware;

use Closure;

class CheckAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(!$request->user()->is_admin) {
            abort(403, 'Acceso denegado. Este espacio es solo para Administradores.');
        }

        return $next($request);
    }
}
