<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateForecastItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('forecast_items', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('model_id');
            $table->bigInteger('model_vid');
            $table->bigInteger('oem_id')->nullable()->default(null);
            $table->bigInteger('odm_id')->nullable()->default(null);
            $table->bigInteger('carrier_id')->nullable()->default(null);
            $table->bigInteger('type_id')->nullable();
            $table->bigInteger('licensee_id')->nullable()->default(null);
            $table->date('date_from');
            $table->date('date_to');
            $table->decimal('coverage', 32, 15);
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
        Schema::dropIfExists('forecast_items');
    }
}
