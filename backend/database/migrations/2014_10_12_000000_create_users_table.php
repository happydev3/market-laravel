<?php

use Illuminate\Support\Facades\Schema;
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

            $table->string('name',64);
            $table->string('email',64)->unique();
            $table->string('password',256);
            $table->string('phone_no',20)->unique();
            $table->enum('status',array('active','missing_payment','blocked'))->default('missing_payment');
            $table->date('active_until')->required();
            $table->unsignedInteger('city_id')->required();
            $table->boolean('email_verified')->default(false);
            $table->boolean('phone_verified')->default(false);
            $table->string('email_verify_token',128);
            $table->string('phone_verify_token',9)->unique();
            $table->string('referral_code',25)->nullable();
            $table->string('own_referral_code',10)->unique();
            $table->string('api_token',150)->unique();
            $table->string('avatar_url',256)->nullable();
            $table->boolean('newsletter')->default(1);

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
        \Illuminate\Support\Facades\DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        Schema::dropIfExists('users');
        \Illuminate\Support\Facades\DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
