<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderShippingAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_shipping_addresses', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('order_id');
            $table->string('name')->required();
            $table->string('address')->required();
            $table->string('house_number')->required();
            $table->string('zip_code')->required();
            $table->string('city')->required();
            $table->unsignedInteger('country_id')->required();
            $table->text('additional_notes')->nullable();
            $table->text('invoice_details')->nullable();
            $table->boolean('invoice_same_address')->default(false);
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
        Schema::dropIfExists('order_shipping_addresses');
    }
}
