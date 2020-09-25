<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGetterTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('getter_transactions', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('getter_id')->required();
            $table->enum('transaction_type',array('online','offline','cash','tradedoubler'));
            $table->enum('event',array('transaction','fee_payment'))->default('transaction'); // Fee Payment = When user pays fee, Transaction = Normal Transaction
            $table->enum("status",array('completed','error','missing_payment'))->default('missing_payment');
            $table->unsignedInteger('transaction_id')->required();
            $table->float('fb_fee_import')->required();
            $table->float('getter_fee_rate');
            $table->float('import');
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
        Schema::dropIfExists('getter_transactions');
    }
}
