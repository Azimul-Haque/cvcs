<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDonationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('donations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('donor_id')->unsigned();
            $table->integer('submitter_id')->unsigned();
            $table->integer('payment_status')->unsigned();
            $table->string('payment_key');
            $table->string('amount');
            $table->string('bank');
            $table->string('branch');
            $table->string('pay_slip');
            $table->string('image');
            $table->foreign('donor_id')->references('id')->on('donors')->onDelete('cascade');
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
        Schema::drop('donations');
    }
}
