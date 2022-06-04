<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('roles', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name',30)->unique();
            $table->string('description',100)->nullable();
            $table->boolean('is_admin')->default(0);
            $table->boolean('state')->default(1);
            //$table->timestamps();
        });

        DB::table('roles')->insert(array('id'=>'1','name'=>'Administrador','description'=>'Administrador','is_admin' => 1));
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('roles');
    }
}
