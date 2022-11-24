<?php

namespace App\Http\Middleware;

use App\Models\Permiso;
use App\Models\Permission;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoutesWithPermission
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
        list($controller, $action) = explode("@",class_basename($request->route()->getAction()["controller"]));
        $permission = Permission::where('id_rol','=', Auth::user()->id_rol)
        ->where('controller','=',$controller)
        ->where('action','=',$action)
        ->where('condition','=',1)
        ->first();

        if(!$permission && !Auth::user()->rol->is_super){
            abort(403,"Permisos insuficientes para ".$action);
        }
        return $next($request);
    }
}
