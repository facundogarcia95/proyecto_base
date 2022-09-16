<?php

namespace App\Http\Controllers\Permission;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use App\Models\Rol;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Redirect;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //OBTENEMOS TODAS LAS RUTAS PARA UN MIDDLEWARE Y QUE NO SEA LA DE PERMISSION CONTROLLER
        $obj_permiso = new Permission();
        $routes = $obj_permiso->list_routes_in_middleware('RoutesWithPermission')->all();
        $permissions =  Permission::all();
        $roles = (Auth::user()->rol->is_super) ? Rol::where('is_super','=',0)->where('condition','=',1)->get() : Rol::where('is_admin','=',0)->where('is_super','=',0)->where('condition','=',1)->get();
        return view('permissions.index',['routes'=>$routes,'roles'=>$roles,'permissions' => $permissions]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       return false;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return false;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return false;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            if($request->id){
                $request->validate([
                    'id' =>  [function($attribute,$value,$fail){
                        $notExist = Permission::where($attribute,Crypt::decryptString($value))->doesntExist();
                        if($notExist){
                            $fail('validation.id_not_exits');
                        }
                    }]
                ]);

                $permission = Permission::findOrFail(Crypt::decryptString($request->id));
                $permission->delete();
                return Redirect::back()->with('success', 'generic.edit_success');
            }else{
                $request->validate([
                    'controller' => 'required',
                    'action' => 'required',
                    'name' => 'required',
                    'idrol' =>  [function($attribute,$value,$fail){
                        $notExist = Rol::where('id','=',Crypt::decryptString($value))->doesntExist();
                        if($notExist){
                            $fail('validation.not_in');
                        }
                    }]
                ]);

                $permission = new Permission();
                $permission->controller = Crypt::decryptString($request->controller);
                $permission->action = Crypt::decryptString($request->action);
                $permission->name = Crypt::decryptString($request->name);
                $permission->idrol = Crypt::decryptString($request->idrol);
                $permission->description = $request->description;
                $permission->save();
                return Redirect::back()->with('success', 'generic.add_success');

            }
        } catch (DecryptException $th) {
            return Redirect::back()->with('warning', 'generic.edit_error');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
