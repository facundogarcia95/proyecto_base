<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Conditions extends Model
{
    use HasFactory;

    protected $table = 'conditions';
	public $timestamps = false;

     /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id',
        'name'
    ];


    /*
     | -----------------------------------
     |   FUNCIONES DE LA CLASE
     | -----------------------------------
     */

}
