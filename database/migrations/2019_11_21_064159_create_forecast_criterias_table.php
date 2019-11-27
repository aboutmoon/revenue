<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateForecastCriteriasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('forecast_criterias', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('model_id');
            $table->bigInteger('model_vid');
            $table->bigInteger('item_id');
            $table->dateTime('date_from');
            $table->dateTime('date_to');
            $table->decimal('value', 24, 8);
            $table->decimal('monthly_growth', 16, 8);
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
        Schema::dropIfExists('forecast_criterias');
    }
}
