<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersAttachedTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users_attached', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_user_owner')->unsigned();
            $table->foreign('id_user_owner')->references('id')->on('users');
            $table->integer('id_user_attached')->unsigned();
            $table->foreign('id_user_attached')->references('id')->on('users');
            $table->integer('condition')->unsigned()->default(1);
            $table->foreign('condition')->references('id')->on('conditions');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users_attached');
    }
}
