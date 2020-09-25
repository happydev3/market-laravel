<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductMultimediaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_multimedia', function (Blueprint $table) {
            $table->increments('id');
            $table->enum('type',array('image','video','document','web_thumb','mobile','mobile_thumb'));
            $table->integer('product_id')->unsigned();
            $table->string('url',512);
            $table->timestamps();
            $table->foreign('product_id')->references('id')->on('products');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_multimedia');
    }
}
