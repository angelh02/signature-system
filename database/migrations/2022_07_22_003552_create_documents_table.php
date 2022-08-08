<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDocumentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('documents', function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->unsignedBigInteger("user_id");
            $table->unsignedBigInteger("container_id");
            $table->unsignedBigInteger("classification_id");
            $table->text("url");
            $table->date("effective_date");
            $table->boolean("signed")->default(false);
            $table->boolean("signed_at")->nullable();
            $table->boolean("canceled")->default(false);
            $table->date("canceled_at");
            $table->date("created_at");
            $table->date("updated_at");
            $table->boolean("reminder");
            $table->integer("days_to_remind");

            //Relations
            $table->foreign("user_id")->references("id")->on("users")->onDelete("cascade");
            $table->foreign("container_id")->references("id")->on("containers")->onDelete("cascade");
            $table->foreign("classification_id")->references("id")->on("classifications")->onDelete("cascade");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('documents');
    }
}
