<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title',256);
            $table->text('description');
            $table->integer('product_category_id')->unsigned();
            $table->float('price')->default(0);
            $table->enum('currency',array('$','£','€'))->default('€');
            $table->integer('store_id')->unsigned();
            $table->string('store_internal_code')->nullable();
            $table->string('redirect_url')->default('#');
            $table->enum('loaded_by',array('vendor','scraper'))->default('scraper');
            $table->string('slug',150)->unique();
            $table->integer('quantity_available')->default(1);
            $table->boolean('active')->default(true);
            $table->timestamps();
            $table->foreign('store_id')->references('id')->on('stores');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        \Illuminate\Support\Facades\DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        Schema::dropIfExists('products');
        \Illuminate\Support\Facades\DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
