<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTitlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('titles', function (Blueprint $table) {
            $table->unsignedMediumInteger('id')->primary();
            $table->string('primaryTitle');
            $table->string('originalTitle');
            $table->boolean('isAdult')->default(false);
            $table->smallInteger('startYear')->nullable();
            $table->smallInteger('endYear')->nullable();
            $table->smallInteger('runtimeMinutes')->nullable();

            $table->unsignedTinyInteger('type_id');
            $table->foreign('type_id')->references('id')->on('types');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('titles');
    }
}
