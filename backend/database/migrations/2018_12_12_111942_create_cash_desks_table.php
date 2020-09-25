<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCashDesksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cash_desks', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('store_branch_id');
            $table->string('desk_name')->required();
            $table->string('code',10)->unique();
            $table->boolean('active')->default(1);
            $table->foreign('store_branch_id')->references('id')->on('store_branches');
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
        Schema::dropIfExists('cash_desks');
    }
}
