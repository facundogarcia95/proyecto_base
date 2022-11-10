<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateBussinesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('bussines', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name',150)->nullable(false);
            $table->integer('condition')->unsigned()->default(1);
            $table->foreign('condition')->references('id')->on('conditions');
            $table->timestamps();
        });

        DB::table('bussines')->insert(array('id'=>'1','name'=>'Empresa Local','condition' => 1,'created_at' => now()));
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bussines');
    }
}
