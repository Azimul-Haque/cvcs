<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('member_id')->unsigned();
            $table->integer('payer_id')->unsigned();
            $table->text('bulk_payment_member_ids');
            $table->integer('payment_status')->unsigned();
            $table->integer('payment_category')->unsigned();
            $table->string('payment_type');
            $table->string('payment_key');
            $table->string('amount');
            $table->string('bank');
            $table->string('branch');
            $table->string('pay_slip');
            $table->integer('is_archieved')->unsigned();
            $table->foreign('member_id')->references('id')->on('users')->onDelete('cascade');
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
        Schema::drop('payments');
    }
}
