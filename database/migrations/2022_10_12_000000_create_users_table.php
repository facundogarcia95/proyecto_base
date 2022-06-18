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
            $table->string('name',100);
            $table->enum('type_doc',['DNI','L.C','L.E','Pasaporte'])->nullable();
            $table->string('num_doc',20)->nullable();
            $table->string('adress',70)->nullable();
            $table->string('cel_number',20)->nullable();
            $table->string('email',50);
            $table->timestamp('email_verified_at')->nullable();
            $table->string('user')->unique();
            $table->string('password');
            $table->enum('condition',['Active','Inactive'])->default('Active');
            $table->integer('idrol')->unsigned();
            $table->foreign('idrol')->references('id')->on('roles');
            $table->rememberToken();
            $table->timestamps();
        });

        $user = [
            ['name' => 'Administrador', 'type_doc' => 'DNI', 'num_doc' => '12345567', 'adress' => 'SIN CALLE', 'cel_number' => '2612288191','email' => 'administrador@gmail.com', 'user' => 'administrador', 'password' => bcrypt('administrador'), 'idrol' => 1, 'created_at' => now()]
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
