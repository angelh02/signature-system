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
            $table->unsignedBigInteger("document_type_id");
            $table->text("url");
            $table->date("effective_date");
            $table->boolean("signed")->default(false);
            $table->date("signed_at")->nullable();
            $table->boolean("canceled")->default(false);
            $table->date("canceled_at")->nullable();
            $table->date("created_at");
            $table->date("updated_at");
            $table->boolean("reminder")->default(false);
            $table->integer("days_to_remind")->default(3);

            //Relations
            $table->foreign("user_id")->references("id")->on("users")->onDelete("cascade");
            $table->foreign("container_id")->references("id")->on("containers")->onDelete("cascade");
            $table->foreign("classification_id")->references("id")->on("classifications")->onDelete("cascade");
            $table->foreign("document_type_id")->references("id")->on("document_types")->onDelete("cascade");
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
