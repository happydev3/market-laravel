<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStoreReviewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('store_reviews', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('store_id')->required();
            $table->unsignedInteger('user_id')->required();
            $table->text('review')->required();
            $table->enum('type',array('positive','negative'))->default('positive');
            $table->boolean('signaled_by_store')->default(0);
            $table->boolean('active')->default(1);
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
        Schema::dropIfExists('store_reviews');
    }
}
