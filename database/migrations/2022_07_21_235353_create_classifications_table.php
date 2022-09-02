<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClassificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('classifications', function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->unsignedBigInteger("background_id");
            $table->unsignedBigInteger("section_id");
            $table->string("series", 20);
            $table->string("subseries", 20)->nullable();
            $table->unsignedBigInteger("production_area_id");
            $table->integer("start_period");
            $table->integer("end_period")->nullable();
            $table->integer("consecutive_number");

            //Relations
            $table->foreign("background_id")->references("id")->on("backgrounds")->onDelete("cascade");
            $table->foreign("section_id")->references("id")->on("sections")->onDelete("cascade");
            $table->foreign("production_area_id")->references("id")->on("production_areas")->onDelete("cascade");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('classifications');
    }
}
