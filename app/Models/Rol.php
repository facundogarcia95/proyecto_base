<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Rol extends Model
{
    use HasFactory;

    protected $table = 'roles';
	public $timestamps = false;

     /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'description',
        'is_admin',
        'condition'
    ];


    /*
     | -----------------------------------
     |   FUNCIONES DE LA CLASE
     | -----------------------------------
     */

     private function create_rol(Rol $rol){

       $response = $rol->save();
       return $response;

     }


     public static function listRoles(Request $request = null){
        if(!empty($request) && isset($request->searchText)){
            $roles = Rol::where('condition','=','Active')
            ->where('name','like','%'.$request->searchText.'%')
            ->orWhere('description','like','%'.$request->searchText.'%');
        }else{
            $roles = Rol::where('roles.condition','=','Active');
        }
        return $roles;
    }

}
