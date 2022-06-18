<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Http\Request;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     */
    protected $fillable = [
        'name',
        'type_doc',
        'num_doc',
        'adress',
        'cel_number',
        'email',
        'user',
        'idrol',
    ];

     /**
     * The attributes that are not mass assignable.
     *
     */
    protected $guarded = [
        'id',
        'condition',
        'remember_token',
        'created_at',
        'updated_at',
        'password',
        'email_verified_at'
    ];

    /**
     * Relashion for model
     *
     */
    public function rol()
	{
		return $this->belongsTo(Rol::class, 'idrol');
	}

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    /*
     | -----------------------------------
     |   FUNCIONES DE LA CLASE
     | -----------------------------------
    */

    public function create_user(User $user){
        $response = $user->save();
        return $response;
    }

    public static function listUsers(Request $request = null){
        if(!empty($request) && isset($request->searchText)){
            $users = User::select('users.*')->join('roles','users.idrol','=','roles.id')
            ->where('roles.condition','=',1)
            ->where('users.name','like','%'.$request->searchText.'%')
            ->orWhere('user','like','%'.$request->searchText.'%')
            ->orWhere('email','like','%'.$request->searchText.'%');
        }else{
            $users = User::select('users.*')->join('roles','users.idrol','=','roles.id')
            ->where('roles.condition','=',1);
        }
        return $users;
    }

}


