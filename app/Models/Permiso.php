<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permiso extends Model
{
    use HasFactory;

    protected $table = 'permisos';
	public $timestamps = false;

     /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'permiso',
        'idrol',
        'estado'
    ];


    /*
     | -----------------------------------
     |   FUNCIONES DE LA CLASE
     | -----------------------------------
     */

     private function create_permiso(Permiso $permiso){

       $response = $permiso->save();
       return $response;

     }

}
