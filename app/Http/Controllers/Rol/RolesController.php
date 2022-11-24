<?php

namespace App\Http\Controllers\Rol;

use App\Http\Controllers\Controller;
use App\Models\Rol;
use App\Models\User;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Redirect;

class RolesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
       /**
         * OBTENER TODOS LOS ROLES
         */
        $roles = Rol::listRoles($request)->paginate(10);
        return view('roles.index',['roles' => $roles]);
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
        //REMOVE UNUSED PARAMETERS
        $request->request->remove('_token');
        $request->request->remove('id');
        $request->merge(['is_admin' => ($request->is_admin == "on") ? 1 : 0]);

        $request->validate([
            'name' => 'required|max:30|unique:roles,name',
            'description' => 'required|max:100',
            'is_admin' => 'required|boolean',
        ]);

        //ADD ROL
        $rol = Rol::create($request->all());
        return Redirect::back()->with('success', 'generic.add_success');
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
    public function edit(Request $request,$id)
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
        if(!Auth::user()->rol->is_admin){
            return Redirect::back()->with('warning', 'generic.not_permissions');
        }

        try {
            $request->merge(['is_admin' => ($request->is_admin == "on") ? 1 : 0]);
            $request->validate([
                'id' =>  [function($attribute,$value,$fail){
                    $notExist = Rol::where($attribute,Crypt::decryptString($value))->doesntExist();
                    if($notExist){
                        $fail('validation.not_in');
                    }
                }],
                'name' => 'required|max:30|unique:roles,name,'.Crypt::decryptString($request->id).',id',
                'description' => 'required|max:100',
                'is_admin' => 'required|boolean',
            ]);
            $rol = Rol::findOrFail(Crypt::decryptString($request->id));
            $rol->update($request->all());
            return Redirect::back()->with('success', 'generic.edit_success');

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
    public function destroy(Request $request,$id)
    {
        try {
            $request->validate([
                'id' =>  [function($attribute,$value,$fail){
                    $notExist = Rol::where($attribute,Crypt::decryptString($value))->doesntExist();
                    if($notExist){
                        $fail('validation.not_in');
                    }
                    $usersInRol = User::where('id_rol','=',Crypt::decryptString($value))->count();
                    if($usersInRol){
                        $fail('validation.users_in_rol');
                    }
                }],
            ]);

            $rol= Rol::findOrFail(Crypt::decryptString($request->id));
            $rol->condition = ($rol->condition == 1) ? 2 : 1;
            $rol->save();
            return Redirect::back()->with('success', 'generic.edit_success');
        } catch (DecryptException $th) {
            return Redirect::back()->with('warning', 'generic.edit_error');
        }
    }

}
