<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSearchRevenueSharingToForecastDevicesView extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('forecast_devices_view', function (Blueprint $table) {
            //(Revenue) App Preload
            $table->decimal('i_c_search_revenue_sharing', 32, 15)->default(0);
            $table->decimal('i_c_search_revenue_sharing_mg', 32, 15)->default(0);
            $table->decimal('i_c_search_revenue_sharing_cg', 32, 15)->default(0);

            $table->decimal('c_srs_revenue_sharing_carrier', 32, 15)->default(0);
            $table->decimal('c_srs_revenue_sharing_carrier_mg', 32, 15)->default(0);
            $table->decimal('c_srs_revenue_sharing_oem', 32, 15)->default(0);
            $table->decimal('c_srs_revenue_sharing_oem_mg', 32, 15)->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('forecast_devices_view', function (Blueprint $table) {
            //
        });
    }
}
