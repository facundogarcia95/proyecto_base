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
            $table->string('name',30)->unique()->nullable(false);
            $table->string('description',100)->nullable(false);
            $table->boolean('is_admin')->default(0);
            $table->boolean('is_super')->default(0);
            $table->integer('condition')->unsigned()->default(1);;
            $table->foreign('condition')->references('id')->on('conditions');
            //$table->timestamps();
        });

        DB::table('roles')->insert(array('id'=>'1','name'=>'Super Usuario','description'=>'Usuario con todos los permisos','is_admin' => 1, 'is_super' => 1,'condition' => 1));
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
