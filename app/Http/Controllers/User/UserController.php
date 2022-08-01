<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Mail\NotifyMailPass;
use App\Mail\NotifyUserAdd;
use App\Models\Rol;
use App\Models\User;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
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
        $roles = Rol::listRoles()->where('condition','=',1)->get();
        return view('users.index',['users'=>$users,'types_doc' => $types_doc,'roles' => $roles]);
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
            $request->validate([
                'name' => 'required|max:100',
                'user' => 'required|max:255|unique:users,user',
                'email' => 'required|email|unique:users,email',
                'type_doc' => [function($attribute,$value,$fail){
                    $types_doc = $this::getPossibleEnumValues(app(User::class)->getTable(),'type_doc');
                    if(!in_array($value,$types_doc)){
                        $fail('validation.not_in');
                    }
                }],
                'num_doc' => 'max:20|unique:users,num_doc',
                'adress' => 'max:70',
                'cel_number' => 'max:20',
                'password' => [function($attribute,$value,$fail){
                    if(!is_null($value)){
                        $fail('validation.not_in');
                    }
                }],
            ]);

            //REMOVE UNUSED PARAMETERS
            $request->request->remove('_token');
            $request->request->remove('id');

            //ADD RAMDOM PASSWORD
            $random_password = $this->ramdomPass();

            $request->request->add(['password'=>$random_password["pass_cryp"]]);

            //ADD USER AND SEND INITIAL PASSWORD
            $user = User::create($request->all());

            //THE FOLLOWING COMMAND SHOULD BE RUN "php artisan queue:work"
            Mail::to($request->email)->send(new NotifyUserAdd($user,$random_password["pass"]));
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {

            $request->validate([
                'id' =>  [function($attribute,$value,$fail){
                    $notExist = User::where($attribute,Crypt::decryptString($value))->doesntExist();
                    if($notExist){
                        $fail('validation.not_in');
                    }
                }],
                'name' => 'required|max:100',
                'user' => 'required|max:255|unique:users,user,'.Crypt::decryptString($request->id).',id',
                'email' => 'required|email|unique:users,email,'.Crypt::decryptString($request->id).',id',
                'type_doc' => [function($attribute,$value,$fail){
                    $types_doc = $this::getPossibleEnumValues(app(User::class)->getTable(),'type_doc');
                    if(!in_array($value,$types_doc)){
                        $fail('validation.not_in');
                    }
                }],
                'num_doc' => 'max:20|unique:users,num_doc,'.Crypt::decryptString($request->id).',id',
                'adress' => 'max:70',
                'cel_number' => 'max:20',
            ]);
            $user = User::findOrFail(Crypt::decryptString($request->id));
            $user->update($request->all());
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
                    $notExist = User::where($attribute,Crypt::decryptString($value))->doesntExist();
                    if($notExist){
                        $fail('validation.not_in');
                    }
                }],
            ]);

            $user= User::findOrFail(Crypt::decryptString($request->id));
            $user->condition = ($user->condition == 1) ? 2 : 1;
            $user->save();
            return Redirect::back()->with('success', 'generic.edit_success');

        } catch (DecryptException $th) {
            return Redirect::back()->with('warning', 'generic.edit_error');
        }
    }

    public function password_reset(Request $request){
        try {
            //ADD RAMDOM PASSWORD
            $random_password = $this->ramdomPass();

            //ADD USER AND SEND INITIAL PASSWORD
            $user = User::findOrFail(Crypt::decryptString($request->id));

            if($user->rol->is_admin){
                return Redirect::back()->with('warning', 'generic.user_not_edition');
            }

            $user->password = $random_password["pass_cryp"];
            $user->save();

            //THE FOLLOWING COMMAND SHOULD BE RUN "php artisan queue:work"
            Mail::to($user->email)->send(new NotifyMailPass($random_password["pass"]));
            return Redirect::back()->with('success', 'generic.edit_password_success');

        }  catch (DecryptException $th) {
            return Redirect::back()->with('warning', 'generic.edit_error');
        }
    }

    private function ramdomPass(){
        $pass = str_shuffle(random_int(100000,999999)."asdf");
        $random_password = Hash::make($pass);

        return [
            "pass" => $pass,
            "pass_cryp" => $random_password
        ];
    }
}
