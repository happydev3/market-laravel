<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCashbackRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cashback_requests', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id')->required();
            $table->float('import')->required();
            $table->string('iban')->required();
            $table->enum('status',array('accepted','done'))->default('accepted');
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
        Schema::dropIfExists('cashback_requests');
    }
}
