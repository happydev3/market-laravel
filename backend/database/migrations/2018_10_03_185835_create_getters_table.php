<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGettersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('getters', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name',64)->required();
            $table->string('email',64)->unique()->required();
            $table->string('iban',34)->unique();
            $table->string('referral_code',25)->unique()->required();
            $table->float('fees_sum')->default(0.00);
            $table->float('fee_rate')->default(10.0);
            $table->unsignedInteger('city_id')->required();
            $table->boolean('active',1)->required();
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
        Schema::dropIfExists('getters');
    }
}
