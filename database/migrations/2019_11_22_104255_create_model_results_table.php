<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateModelResultsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('model_results', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('model_id');
            $table->bigInteger('model_vid');
            $table->bigInteger('location_id');
            $table->bigInteger('project_id');
            $table->date('date_from');
            $table->date('date_to');
            $table->bigInteger('item_id');
            $table->decimal('result', 24, 8);
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
        Schema::dropIfExists('model_results');
    }
}
