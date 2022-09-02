<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDocumentSignerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('document_signer', function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->string("email");
            $table->unsignedBigInteger("document_id");
            $table->boolean("signed")->default(false);
            $table->date("signed_at")->nullable();

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
        Schema::dropIfExists('document_signer');
    }
}
