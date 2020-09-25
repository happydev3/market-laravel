<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('invoice_number');
            $table->date('date')->required();
            $table->enum('invoice_type',array('transaction_invoice','cashback_invoice'))->default('transaction_invoice');
            $table->enum('transaction_type',array('online','offline','cash','other'));
            $table->unsignedInteger('transaction_id');
            $table->unsignedInteger('store_id');
            $table->float('total')->required();
            $table->float('freeback_fee')->required();
            $table->float('cashback_fee')->required();
            $table->boolean('valid')->default(true);
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
        Schema::dropIfExists('invoices');
    }
}
