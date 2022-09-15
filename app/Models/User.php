<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Http\Request;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\ListadoAjax;

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
        'password',
        'condition'
    ];

     /**
     * The attributes that are not mass assignable.
     *
     */
    protected $guarded = [
        'id',
        'remember_token',
        'created_at',
        'updated_at',
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
     * Relashion for conditions
     *
     */
    public function getCondition()
	{
		return $this->belongsTo(Conditions::class, 'condition');
	}


    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'remember_token',
        'password',
        'created_at',
        'updated_at',
        'email_verified_at',
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

    public static function listUsers($params = []){
        $columns = 'users.name,users.email,users.user';

        $params['start']  = (!isset($params['start'])  || empty($params['start']) )  ? 0 :$params['start'];
        $params['lenght'] = (!isset($params['lenght']) || empty($params['lenght']) ) ? 10 :$params['lenght'];
        $params['search'] = (!isset($params['search']) || empty($params['search']) ) ? '' :$params['search'];

        $query = User::select('users.*','roles.name as rolname','conditions.name as condition_name')->join('roles','users.idrol','=','roles.id')
        ->join('conditions','users.condition','=','conditions.id')
        ->where('roles.condition','=',1);

        $data = ListadoAjax::listAjax($columns, $query, $params);

        return $data;
    }

}


