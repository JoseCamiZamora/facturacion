<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class is_admin
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
        
        $usuario_actual=Auth::user();
        if ($usuario_actual->rol!=1) {

            return view('facturas.mensajes.msj_error')->with("msj","No tiene Autorizacion para ingresar a esta sección");
        }
        return $next($request);
    }
}
