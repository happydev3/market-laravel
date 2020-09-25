<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStoreReferralTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('store_referral_transactions', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('store_id');
            $table->unsignedInteger('user_id');
            $table->enum("transaction_type",array('online','offline','cash','tradedoubler'));
            $table->unsignedInteger('transaction_id')->required();
            $table->string('dp_push_id')->nullable();
            $table->enum('status',array('completed','error','other','missing_payment'))->default('missing_payment');
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
        Schema::dropIfExists('store_referral_transactions');
    }
}
