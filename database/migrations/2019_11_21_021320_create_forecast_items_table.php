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
            $table->bigInteger('fi_location_id');
            $table->bigInteger('fi_item_id');
            $table->bigInteger('date_from_id');
            $table->bigInteger('date_to_id');
            $table->decimal('coverage', 24, 8);
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
