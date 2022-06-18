<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Rol;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        /**
         * OBTENER TODOS LOS USUARIOS QUE TIENE ROL ACTIVO Y NO ES ADMINISTRADOR
         */
        $users = User::listUsers($request)->paginate(10);
        $types_doc = $this::getPossibleEnumValues(app(User::class)->getTable(),'type_doc');
        $roles = Rol::listRoles()->get();
        return view('users.index',['users'=>$users,'types_doc' => $types_doc,'roles' => $roles]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        dd($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        $request->validate([
            'id' => 'required|integer|exists:users,id',
            'name' => 'required|max:100',
            'email' => 'required|email|unique:users,email,'.$request->id,',id',
            'type_doc' => [function($attribute,$value,$fail){
                $types_doc = $this::getPossibleEnumValues(app(User::class)->getTable(),'type_doc');
                if(!in_array($value,$types_doc)){
                    $fail('validation.not_in');
                }
            }],
            'num_doc' => 'max:20',
            'adress' => 'max:70',
            'cel_number' => 'max:20',
        ]);

        $user = User::findOrFail($request->id);
        $user->update($request->all());

        return Redirect::back()->with('success', 'generic.edit_success');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,$id)
    {
        dd($request->all());
    }
}
