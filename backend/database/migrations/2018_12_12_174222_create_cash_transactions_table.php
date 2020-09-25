<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCashTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cash_transactions', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('store_id')->required();
            $table->unsignedInteger('branch_id')->required();
            $table->unsignedInteger('cash_desk_id')->required();
            $table->unsignedInteger('user_id')->required();

            $table->float('full_import')->required();
            $table->float('discount_rate')->required();
            $table->float('freeback_rate')->required();
            $table->float('cashback_neto')->required();
            $table->float('freeback_neto')->required();

            $table->enum('status',array('accepted','declined','sent'))->default('sent');
            $table->unsignedInteger('cash_invoice_id')->nullable();

            $table->boolean('notified')->default(0);
            $table->boolean('royalty_check')->default(0);
            $table->boolean('invoiced')->default(0);

            $table->timestamps();
            $table->foreign('store_id')->references('id')->on('stores');
            $table->foreign('branch_id')->references('id')->on('store_branches');
            $table->foreign('cash_desk_id')->references('id')->on('cash_desks');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cash_transactions');
    }
}
