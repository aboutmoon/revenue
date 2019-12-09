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
            $table->bigInteger('location_id');
            $table->bigInteger('account_id');
            $table->bigInteger('model_id');
            $table->bigInteger('model_vid');
            $table->date('date');
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
        Schema::dropIfExists('forecast_items_view');
    }
}
