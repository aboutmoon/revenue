<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateForecastItemsView extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('forecast_items_view', function (Blueprint $table) {
            $table->bigInteger('item_id');
            $table->bigInteger('project_id');
            $table->bigInteger('location_id');
            $table->bigInteger('market_id');
            $table->bigInteger('model_id');
            $table->bigInteger('model_vid');
            $table->date('date');
            $table->date('date_from');
            $table->decimal('coverage', 32, 15);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('forecast_items_view');
    }
}
