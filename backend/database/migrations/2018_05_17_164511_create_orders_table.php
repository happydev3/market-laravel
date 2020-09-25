<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('user_id')->required();
            $table->unsignedInteger('store_id')->required();
            $table->unsignedInteger('product_id')->required();
            $table->unsignedInteger('product_quantity')->required();

            $table->date('disputable_until')->required();
            $table->boolean('disputed')->default(0);
            $table->enum('status',array('missing_payment','recieved','processed','sent','delivered'))->default('missing_payment');
            $table->enum('courier',array('DHL','BRT','SDA','GLS','NO'))->default('NO');
            $table->unsignedInteger('order_shipping_addresses_id')->required();
            $table->unsignedInteger('online_transaction_id')->required();
            $table->boolean('reviewed')->default(0);
            $table->string('tracking_no')->nullable();
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
        Schema::dropIfExists('orders');
    }
}
