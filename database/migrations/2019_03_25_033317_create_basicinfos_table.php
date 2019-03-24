<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBasicinfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('basicinfos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('address');
            $table->string('contactno');
            $table->string('email');
            $table->string('fb');
            $table->string('twitter');
            $table->string('gplus');
            $table->string('ytube');
            $table->string('linkedin');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('basicinfos');
    }
}
