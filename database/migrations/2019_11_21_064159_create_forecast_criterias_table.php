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
            $table->bigInteger('fc_location_id');
            $table->bigInteger('fc_account_id');
            $table->bigInteger('criteria_id');
            $table->bigInteger('date_from_id');
            $table->bigInteger('date_to_id');
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
