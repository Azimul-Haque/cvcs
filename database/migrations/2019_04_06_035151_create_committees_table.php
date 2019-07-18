<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCommitteesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('committees', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('committee_type');
            $table->string('name');
            $table->string('email');
            $table->string('phone');
            $table->string('designation');
            $table->string('fb')->nullable();
            $table->string('twitter')->nullable();
            $table->string('gplus')->nullable();
            $table->string('linkedin')->nullable();
            $table->string('image')->nullable();
            $table->integer('serial')->default(0);
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
        Schema::drop('committees');
    }
}
