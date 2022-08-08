<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDocumentSignedTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('document_signed', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("document_id");
            $table->text("pdf_url");
            $table->text("xml_url");
            
            //Relations
            $table->foreign("document_id")->references("id")->on("documents")->onDelete("cascade");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('document_signed');
    }
}
