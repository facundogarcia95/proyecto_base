<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateBusinessTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('business', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name',150)->nullable(false)->unique();
            $table->integer('condition')->unsigned()->default(1);
            $table->foreign('condition')->references('id')->on('conditions');
            $table->timestamps();
        });

        DB::table('business')->insert(
            [
                array('name'=>'Empresa Local','condition' => 1,'created_at' => now()),
                array('name'=>'Escribania Uno','condition' => 1,'created_at' => now()),
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
        Schema::dropIfExists('business');
    }
}
