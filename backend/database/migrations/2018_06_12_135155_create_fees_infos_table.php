<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFeesInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fees_infos', function (Blueprint $table) {
            $table->increments('id');
            $table->float('user_import')->default(0);
            $table->float('store_import')->default(0);
            $table->float('transaction_import')->default(30);
            $table->float('royalty_fee')->default(20);
            $table->float('minimum_requestable_import')->default(10.00);
            $table->enum('currency',array('€','$','£'))->default('€');
            $table->unsignedInteger('country_id')->required();
            $table->boolean('active')->default(1);
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
        Schema::dropIfExists('fees_infos');
    }
}
