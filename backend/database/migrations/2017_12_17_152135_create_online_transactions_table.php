<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOnlineTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('online_transactions', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id')->required();
            $table->unsignedInteger('store_id')->required();
            $table->unsignedInteger('order_id')->nullable();

            $table->float('full_import')->required();
            $table->float('discount_rate')->required();
            $table->float('freeback_rate')->required();
            $table->float('cashback_neto')->required();
            $table->float('freeback_neto')->required();


            $table->enum('status',array('created','refused','error','completed'))->default('created');
            $table->string('dp_pull_id')->nullable();

            $table->boolean('invoiced')->default(false);
            $table->unsignedInteger('invoice_id')->default(0);
            $table->boolean('royalty_check')->default(0);
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
        Schema::dropIfExists('online_transactions');
    }
}
