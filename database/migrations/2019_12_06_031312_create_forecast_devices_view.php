<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateForecastDevicesView extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('forecast_devices_view', function (Blueprint $table) {
            $table->bigInteger('model_id');
            $table->bigInteger('model_vid');
            $table->bigInteger('carrier_id')->default(0);
            $table->bigInteger('oem_id')->default(0);
            $table->bigInteger('odm_id')->default(0);
            $table->string('project')->default('');
            $table->string('connectivity')->default('');
            $table->string('brand');
            $table->string('licensee');
            $table->string('type');
            $table->bigInteger('location_id');
            $table->date('date');
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
        Schema::dropIfExists('forecast_devices_view');
    }
}
