<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreatePermissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('permissions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('idrol')->unsigned();
            $table->foreign('idrol')->references('id')->on('roles');
            $table->string('controller',100)->nullable(false);
            $table->string('action',100)->nullable(false);
            $table->string('name',100)->nullable();
            $table->text('description')->nullable();
            $table->boolean('state')->default(1);
        });

        DB::table('permissions')->insert([
                ['idrol'=>'1','controller'=>'UserController','action'=>'index','name'=>'users','description' => 'Permite ver listado de Usuarios'],
                ['idrol'=>'1','controller'=>'RolesController','action'=>'index','name'=>'roles','description' => 'Permite ver listado de Roles que no son administrador'],
                ['idrol'=>'1','controller'=>'PermissionController','action'=>'index','name'=>'permissions','description' => 'Permite ver listado de permisos activos para el rol del usuario']
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