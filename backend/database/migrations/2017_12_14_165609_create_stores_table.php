<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stores', function (Blueprint $table) {
            $table->increments('id');
            $table->string('email',64)->unique();
            $table->string('password',256);
            $table->string('business_name',150)->required();
            $table->string('vat_number',30)->required()->unique();
            $table->string('ae_code',60)->nullable(); // Invoice Code for Agenzia delle Entrate
            $table->integer('store_category_id')->unsigned();

            $table->float('discount_rate')->default(1);
            $table->float('freeback_rate')->default(30);  //Da Intendersi :  Percentuale della Discount Rate

            $table->string('referral_code',25)->nullable();
            $table->string('own_referral_code',10)->required();


            $table->string('permalink',150)->required()->unique();
            $table->string('website',200)->nullable();
            $table->string('phone_number',20)->required()->unique();

            $table->boolean('active')->default(true);
            $table->boolean('email_verified')->default(false);
            $table->string('email_verify_code',140)->required();
            $table->enum('store_type',array('physical','online','both'));

            $table->rememberToken();
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
        \Illuminate\Support\Facades\DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        Schema::dropIfExists('stores');
        \Illuminate\Support\Facades\DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
