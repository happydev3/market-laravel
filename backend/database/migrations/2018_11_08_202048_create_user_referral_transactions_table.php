<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserReferralTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_referral_transactions', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id')->required();
            $table->unsignedInteger('invited_user')->required();
            $table->string('dp_push_id')->nullable();
            $table->float('import');
            $table->enum('status',array('completed','error','other'))->default('completed');
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
        Schema::dropIfExists('user_referral_transactions');
    }
}
