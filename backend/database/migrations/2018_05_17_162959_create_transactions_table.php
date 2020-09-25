<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('store_id')->required();
            $table->unsignedInteger('store_branch_id')->required();
            $table->unsignedInteger('cash_desk_id')->required();
            $table->unsignedInteger('user_id')->required();

            $table->float('full_import')->required(); // 100

            $table->float('discount_rate')->required();
            $table->float('freeback_rate')->required();
            $table->float('cashback_neto')->required();
            $table->float('freeback_neto')->required();


            $table->enum('status',array('created','refused','error','completed'))->default('completed');
            $table->string('dp_pull_id')->nullable();

            $table->string('qr_code')->required();
            $table->boolean('notified')->default(0);
            $table->boolean('royalty_check')->default(0);
            $table->boolean('invoiced')->default(false);
            $table->unsignedInteger('invoice_id')->default(0);

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
        Schema::dropIfExists('transactions');
    }
}
