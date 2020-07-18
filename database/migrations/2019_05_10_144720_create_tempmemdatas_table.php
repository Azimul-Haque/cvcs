<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTempmemdatasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tempmemdatas', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->string('designation');
            $table->integer('position_id')->unsigned();
            $table->string('office');
            $table->integer('branch_id')->unsigned();
            $table->dateTime('start_time')->nullable();
            $table->string('present_address');
            $table->string('mobile');
            $table->string('email');
            $table->string('blood_group')->nullable();
            $table->string('prl_date')->nullable();
            $table->integer('upazilla_id')->unsigned();
            $table->string('image');
            $table->string('digital_signature');
            $table->string('application_hard_copy');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
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
        Schema::drop('tempmemdatas');
    }
}
