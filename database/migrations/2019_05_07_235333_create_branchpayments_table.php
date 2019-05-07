<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBranchpaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('branchpayments', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('branch_id')->unsigned();
            $table->integer('submitter_id')->unsigned();
            $table->integer('payment_status')->unsigned();
            $table->string('payment_key');
            $table->string('amount');
            $table->string('bank');
            $table->string('branch_name'); // branch is a method of it that is why the change!
            $table->string('pay_slip');
            $table->string('image');
            $table->foreign('branch_id')->references('id')->on('branches')->onDelete('cascade');
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
        Schema::drop('brachpayments');
    }
}
