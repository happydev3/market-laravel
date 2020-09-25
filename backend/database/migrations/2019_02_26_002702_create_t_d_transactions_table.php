<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTDTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('t_d_transactions', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id')->required();
            $table->unsignedInteger('t_d_store')->required();
            $table->float('full_import')->required();
            $table->float('discount_rate')->required();
            $table->float('freeback_rate')->required();
            $table->float('freeback_neto')->required();
            $table->float('cashback_neto')->required();
            $table->boolean('royalty_check')->default(0);
            $table->boolean('active')->default(1);
            $table->timestamps();
            $table->foreign('t_d_store')->references('id')->on('t_d_stores');
            $table->foreign('user_id')->references('id')->on('users');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('t_d_transactions');
    }
}
