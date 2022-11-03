<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDeletionRequestTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('deletion_request', function (Blueprint $table) {
            $table->id();
            $table->string('subject');
            $table->text('description');
            $table->unsignedBigInteger('document_id');
            $table->enum('status', ['Pendiente', 'Aceptado', 'Rechazado'])->default('Pendiente');
            $table->date('date');

            //Relations
            $table->foreign('document_id')->references('id')->on('documents')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('deletion_request');
    }
}
