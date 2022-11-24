<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Business extends Model
{
    use HasFactory;
    
    protected $table = 'business';
	public $timestamps = false;

     /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'condition'
    ];

    protected $guarded = [
    ];

     /**
     * Relashion for conditions
     *
     */
    public function getCondition()
	{
		return $this->belongsTo(Conditions::class, 'condition','id');
	}
}
