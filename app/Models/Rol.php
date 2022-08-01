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

    protected $guarded = [
        'is_super',
    ];

     /**
     * Relashion for conditions
     *
     */
    public function getCondition()
	{
		return $this->belongsTo(Conditions::class, 'condition','id');
	}

    /*
     | -----------------------------------
     |   FUNCIONES DE LA CLASE
     | -----------------------------------
     */


     public static function listRoles(Request $request = null){
        if(!empty($request) && isset($request->searchText)){
            $roles = Rol::where('name','like','%'.$request->searchText.'%')
            ->orWhere('description','like','%'.$request->searchText.'%');
        }else{
            $roles = Rol::whereNotNull('name');
        }
        return $roles;
    }

}
