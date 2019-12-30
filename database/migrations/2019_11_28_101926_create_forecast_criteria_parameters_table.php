<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateForecastCriteriaParametersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('forecast_criteria_parameters', function (Blueprint $table) {
            $table->bigInteger('forecast_criteria_id');
            $table->bigInteger('criteria_id');
            $table->date('date_from');
            $table->date('date_to');
            $table->decimal('value', 32, 15);
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
        Schema::dropIfExists('forecast_criteria_parameters');
    }
}
