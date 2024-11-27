<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateConditionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $this->down();
        Schema::create('conditions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name',30)->unique()->nullable(false);
        });

        $conditions = [
            ['name' => 'Active'],
            ['name' => 'Inactive'],
            ['name' => 'Delete'],
        ];

        DB::table('conditions')->insert($conditions);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('conditions');
    }
}
