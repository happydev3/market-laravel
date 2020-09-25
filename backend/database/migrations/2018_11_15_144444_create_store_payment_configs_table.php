<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStorePaymentConfigsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('store_payment_configs', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('store_id')->required();
            $table->boolean('dp_connected')->default(false);
            $table->string('dp_connection_id')->required();
            $table->string('dp_connection_code')->nullable();
            $table->string('dp_pull_id')->required();
            $table->boolean('dp_pull_granted')->nullable();
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
        Schema::dropIfExists('store_payment_configs');
    }
}
