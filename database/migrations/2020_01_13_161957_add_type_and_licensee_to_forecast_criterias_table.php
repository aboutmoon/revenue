<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTypeAndLicenseeToForecastCriteriasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('forecast_criterias', function (Blueprint $table) {
            $table->bigInteger('licensee_id')->default(0)->nullable();
            $table->bigInteger('type_id')->default(0)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('forecast_criterias', function (Blueprint $table) {
            $table->dropColumn('licensee_id');
            $table->dropColumn('type_id');
        });
    }
}
