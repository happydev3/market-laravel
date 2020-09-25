<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTradeDoublerTrackingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trade_doubler_trackings', function (Blueprint $table) {
            $table->increments('id');
            $table->string('subscription_id')->required();
            $table->unsignedInteger('user_id')->required();
            $table->unsignedInteger('program_id')->required();
            $table->unsignedInteger('site_id')->required();
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
        Schema::dropIfExists('trade_doubler_trackings');
    }
}
