<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTdStoreDiscountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('td_store_discounts', function (Blueprint $table) {
            $table->increments('id');
            $table->string("category")->required();
            $table->float("cashback")->required();
            $table->boolean("active")->default(1);
            $table->unsignedInteger("t_d_store_id")->required();
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
        Schema::dropIfExists('td_store_discounts');
    }
}
