<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContainersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('containers', function (Blueprint $table) {
            $table->id();
            $table->string("name", 30);
            $table->unsignedBigInteger("document_value_id");
            $table->unsignedBigInteger("conservation_time_id");
            $table->unsignedBigInteger("selection_technique_id");
            $table->unsignedBigInteger("conservation_type_id");
            $table->unsignedBigInteger("information_type_id");
            $table->date("effective_date");

            //Relations
            $table->foreign("document_value_id")->references("id")->on("document_values")->onDelete("cascade");
            $table->foreign("conservation_time_id")->references("id")->on("conservation_times")->onDelete("cascade");
            $table->foreign("selection_technique_id")->references("id")->on("selection_techniques")->onDelete("cascade");
            $table->foreign("conservation_type_id")->references("id")->on("conservation_types")->onDelete("cascade");
            $table->foreign("information_type_id")->references("id")->on("information_types")->onDelete("cascade");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('containers');
    }
}
