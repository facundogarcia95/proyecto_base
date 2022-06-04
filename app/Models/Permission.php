<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

class Permission extends Model
{
    use HasFactory;

    protected $table = 'permissions';
	public $timestamps = false;

     /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'idrol',
        'controller',
        'action',
        'name',
        'description',
        'state'
    ];


    /*
     | -----------------------------------
     |   FUNCIONES DE LA CLASE
     | -----------------------------------
     */

     private function create_permiso(Permission $permission){

       $response = $permission->save();
       return $response;

     }

     //OBTENEMOS TODAS LAS RUTAS CON EL MIDDLEWARE PermisosMiddleware
     public function list_routes_in_middleware($middleware = ''){
        $all_routes = Route::getRoutes();
        $routes = collect();
        $permissions = Permission::where('state','=',1)->where('idrol','=',Auth::user()->idrol)->get();
        foreach ($all_routes as $item) {
            if(in_array($middleware,$item->getAction()["middleware"])){
                list($controller, $action) = explode("@",class_basename($item->getAction()["controller"]));
                $filtered = $permissions->where('controller','=',$controller)->where('action','=',$action)->first();
                if(!empty($filtered)){
                    $routes->push($filtered);
                }else{
                    $ruta = new Permission();
                    $ruta->controller = $controller;
                    $ruta->action = $action;
                    $ruta->name = $item->getName();
                    $routes->push($ruta);
                }
            }
        }

        return $routes->all();
     }

}
