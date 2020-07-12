<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUpazillasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('upazillas', function (Blueprint $table) {
            $table->increments('id');
            $table->string('district');
            $table->string('district_bangla');
            $table->string('upazilla');
            $table->string('upazilla_bangla');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('upazillas');
    }
}
