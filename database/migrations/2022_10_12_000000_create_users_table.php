<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre',100);
            $table->enum('tipo_documento',['DNI','L.C','L.E','Pasaporte'])->nullable();
            $table->string('num_documento',20)->nullable();
            $table->string('direccion',70)->nullable();
            $table->string('telefono',20)->nullable();
            $table->string('email',50)->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('usuario')->unique();
            $table->string('password');
            $table->boolean('estado')->default(1);
            $table->integer('idrol')->unsigned();
            $table->foreign('idrol')->references('id')->on('roles');
            $table->rememberToken();
            $table->timestamps();
        });

        $user = [
            ['nombre' => 'Administrador', 'tipo_documento' => 'DNI', 'num_documento' => '12345567', 'direccion' => 'SIN CALLE', 'telefono' => '2612288191','email' => 'administrador@gmail.com', 'usuario' => 'administrador', 'password' => bcrypt('administrador'), 'estado' => 1, 'idrol' => 1]
        ];
         DB::table('users')->insert($user);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
