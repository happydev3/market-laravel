<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStoreNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('store_notifications', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title')->required();
            $table->string('text')->required();
            $table->unsignedInteger('store_id')->required();
            $table->enum('type',array('product_shipped','marketing','general_info'))->default('general_info');
            $table->boolean('seen')->default(false);
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
        Schema::dropIfExists('store_notifications');
    }
}
