<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTDStoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('t_d_stores', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string("email");
            $table->string('target_url');
            $table->unsignedInteger('program_id')->required()->unique();
            $table->text("store_description")->nullable();
            $table->string('front_thumbnail')->nullable();
            $table->string('bg_image')->required();
            $table->string('logo')->required();
            $table->enum("tracking_time",array("day","week","month","3month"))->default("week");
            $table->enum("credit_time",array("day","week","month","3month"))->default("week");
            $table->float('cashback')->default(0);
            $table->boolean('active')->default(1);
            $table->string('slug',128)->unique();
            $table->unsignedInteger('store_category_id')->required();
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
        Schema::dropIfExists('t_d_stores');
    }
}
