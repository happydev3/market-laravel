<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserPaymentConfigsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_payment_configs', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id')->required();
            $table->boolean('dp_connected')->default(false);
            $table->string('dp_connection_id')->required();
            $table->string('dp_connection_code')->nullable();
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
        Schema::dropIfExists('user_payment_configs');
    }
}
