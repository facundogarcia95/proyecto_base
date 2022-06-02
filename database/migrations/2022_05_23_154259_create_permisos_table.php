<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreatePermisosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('permisos', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('idrol')->unsigned();
            $table->foreign('idrol')->references('id')->on('roles');
            $table->string('controller',100)->nullable(false);
            $table->string('action',100)->nullable(false);
            $table->string('nombre',100)->nullable();
            $table->text('descripcion')->nullable();
            $table->boolean('estado')->default(1);
        });

        DB::table('permisos')->insert([
                ['idrol'=>'1','controller'=>'UserController','action'=>'index','nombre'=>'usuarios','descripcion' => 'Permite ver listado de Usuarios'],
                ['idrol'=>'1','controller'=>'RolesController','action'=>'index','nombre'=>'roles','descripcion' => 'Permite ver listado de Roles que no son administrador'],
                ['idrol'=>'1','controller'=>'PermisosController','action'=>'index','nombre'=>'permisos','descripcion' => 'Permite ver listado de permisos activos para el rol del usuario']
            ]
        );

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('permisos');
    }
}
