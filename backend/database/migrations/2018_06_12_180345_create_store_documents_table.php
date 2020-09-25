<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStoreDocumentsTable extends Migration
{
    public function up()
    {
        Schema::create('store_documents', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('store_id');
            $table->boolean('valid')->default(0);
            $table->enum('type',array('v_camerale','id','piva')); //v_camerale == Visura Camerale, id == Documento d'Identità, piva == Concessione P.IVA
            $table->string('document_url')->required();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('store_documents');
    }
}
