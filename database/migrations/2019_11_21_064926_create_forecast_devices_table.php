<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateForecastDevicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('forecast_devices', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('model_id');
            $table->bigInteger('model_vid');
            $table->bigInteger('project_id');
            $table->bigInteger('location_id');
            $table->date('date_from');
            $table->date('date_to');
            $table->decimal('quantity', 24, 8)->default(0);
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
        Schema::dropIfExists('forecast_devices');
    }
}
