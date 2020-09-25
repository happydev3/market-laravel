<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCashInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cash_invoices', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedBigInteger('invoice_number')->unique();
            $table->date("date");
            $table->unsignedInteger('store_id');
            $table->float("total");
            $table->float('freeback_fee');
            $table->float("cashback_fee");
            $table->boolean("paid")->default(0);
            $table->boolean("valid")->default(1);
            $table->boolean('sent')->default(0);
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
        Schema::dropIfExists('cash_invoices');
    }
}
