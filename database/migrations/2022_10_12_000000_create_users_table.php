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
            $table->string('num_doc',20)->unique()->nullable();
            $table->string('adress',70)->nullable();
            $table->string('cel_number',20)->nullable();
            $table->string('email',50);
            $table->timestamp('email_verified_at')->nullable();
            $table->string('user')->unique();
            $table->string('password');
            $table->integer('condition')->unsigned()->default(1);
            $table->foreign('condition')->references('id')->on('conditions');
            $table->integer('id_rol')->unsigned();
            $table->foreign('id_rol')->references('id')->on('roles');
            $table->integer('id_business')->unsigned();
            $table->foreign('id_business')->references('id')->on('business');
            $table->rememberToken();
            $table->timestamps();
        });

        $user = [
            ['name' => 'Super Usuario', 'type_doc' => 'DNI', 'num_doc' => '12345567', 'adress' => 'SIN CALLE', 'cel_number' => '2612288191','email' => 'facunditogarcia@gmail.com', 'email_verified_at'=> now(), 'user' => 'super', 'password' => bcrypt('1234'), 'id_rol' => 1, 'id_business' => 1, 'created_at' => now()]
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
