<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDropPayConfigurationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('drop_pay_configurations', function (Blueprint $table) {
            $table->increments('id');
            $table->string('access_token')->required();
            $table->string('refresh_token')->required();
            $table->unsignedInteger('expires_in')->required();
            $table->boolean('valid')->default(1);
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
        Schema::dropIfExists('drop_pay_configurations');
    }
}
