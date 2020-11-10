<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTemppaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('temppayments', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('member_id');
            $table->string('trxid');
            $table->integer('amount');
            $table->string('bulkdata')->nullable();
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
        Schema::drop('temppayments');
    }
}
