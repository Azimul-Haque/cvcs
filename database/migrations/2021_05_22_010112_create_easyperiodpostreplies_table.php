<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEasyperiodpostrepliesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('easyperiodpostreplies', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('easyperiodpost_id');
            $table->string('uid');
            $table->string('anonymous')->default('Anonymous');
            $table->text('reply');
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
        Schema::drop('easyperiodpostreplies');
    }
}
