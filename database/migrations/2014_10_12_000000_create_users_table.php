<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('unique_key')->unique();
            $table->string('member_id')->unique();
            $table->string('role');
            $table->string('role_type');
            $table->integer('activation_status');

            $table->string('name_bangla');
            $table->string('name');
            $table->string('nid');
            $table->string('dob');
            $table->string('gender');
            $table->string('spouse');
            $table->string('spouse_profession');
            $table->string('father');
            $table->string('mother');
            $table->string('profession');
            $table->string('designation');
            $table->string('membership_designation'); // designation during the time of application...
            $table->string('office');
            $table->string('joining_date')->nullable();
            $table->string('present_address');
            $table->string('permanent_address');
            $table->string('office_telephone');
            $table->string('mobile');
            $table->string('home_telephone');
            $table->string('email')->unique();
            $table->string('image');

            $table->string('nominee_one_name');
            $table->integer('nominee_one_identity_type');
            $table->string('nominee_one_identity_text');
            $table->string('nominee_one_relation');
            $table->string('nominee_one_percentage');
            $table->string('nominee_one_image');

            $table->string('nominee_two_name');
            $table->integer('nominee_two_identity_type');
            $table->string('nominee_two_identity_text');
            $table->string('nominee_two_relation');
            $table->string('nominee_two_percentage');
            $table->string('nominee_two_image');

            $table->string('application_payment_amount');
            $table->string('application_payment_bank');
            $table->string('application_payment_branch');
            $table->string('application_payment_pay_slip');
            $table->string('application_payment_receipt');

            $table->string('password');
            $table->rememberToken();
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
        Schema::drop('users');
    }
}
