<?php

namespace App\Http\Middleware;

use App\Models\Permiso;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PermisosMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $controlador_metodo = explode("@",class_basename($request->route()->getAction()["controller"]));
        $permiso = Permiso::where('idrol','=', Auth::user()->idrol)
        ->where('controlador','=',$controlador_metodo[0])
        ->where('metodo','=',$controlador_metodo[1])
        ->where('estado','=',1)
        ->first();

        if(!$permiso){
            abort(403,"Permisos insuficientes.");
        }
        return $next($request);
    }
}