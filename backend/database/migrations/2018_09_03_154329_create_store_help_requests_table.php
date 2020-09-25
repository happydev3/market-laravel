<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStoreHelpRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('store_help_requests', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('store_id');
            $table->text('request');
            $table->boolean('answered')->default(0);
            $table->text('answer')->nullable();
            $table->unsignedInteger('admin_id')->nullable();
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
        Schema::dropIfExists('store_help_requests');
    }
}
