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
            $table->increments('id');
            $table->bigInteger('model_id');
            $table->bigInteger('model_vid');
            $table->bigInteger('location_id');
            $table->bigInteger('market_id');
            $table->decimal('confidence',32,15);
            $table->bigInteger('project_id');
            $table->decimal('quantity', 32, 15)->default(0);
            $table->date('date');



            //shipment
            $table->decimal('i_shipment', 32, 15)->default(0);
            $table->decimal('i_shipment_mg', 32, 15)->default(0);

            $table->decimal('c_shipment', 32, 15)->default(0);
            $table->decimal('c_shipment_mg', 32, 15)->default(0);

            //install base
            $table->decimal('i_install_base', 32, 15)->default(0);
            $table->decimal('i_install_base_mg', 32, 15)->default(0);
            $table->decimal('c_chrun_rate', 32, 15)->default(0);
            $table->decimal('c_chrun_rate_mg', 32, 15)->default(0);
            $table->integer('c_lifetime')->default(0);
            $table->decimal('c_lifetime_mg', 32, 15)->default(0);

            //activated device
            $table->decimal('i_activated_device', 32, 15)->default(0);
            $table->decimal('i_activated_device_mg', 32, 15)->default(0);
            $table->decimal('c_activation_ratio', 32, 15)->default(0);
            $table->decimal('c_activation_ratio_mg', 32, 15)->default(0);

            //mau
            $table->decimal('i_mau', 32, 15)->default(0);
            $table->decimal('i_mau_mg', 32, 15)->default(0);
            $table->decimal('c_initial_mau_ratio', 32, 15)->default(0);
            $table->decimal('c_initial_mau_ratio_mg', 32, 15)->default(0);
            $table->decimal('c_mau_growth_factor', 32, 15)->default(0);
            $table->decimal('c_mau_growth_factor_mg', 32, 15)->default(0);

            //ads mau
            $table->decimal('i_ads_mau', 32, 15)->default(0);
            $table->decimal('i_ads_mau_mg', 32, 15)->default(0);
            $table->decimal('c_ads_dau_from_mau', 32, 15)->default(0);
            $table->decimal('c_ads_dau_from_mau_mg', 32, 15)->default(0);

            //fota fee
            $table->decimal('i_fota_fee', 32, 15)->default(0);
            $table->decimal('i_fota_fee_mg', 32, 15)->default(0);
            $table->decimal('c_fota_fee', 32, 15)->default(0);
            $table->decimal('c_fota_fee_mg', 32, 15)->default(0);

            //search revenue sharing
            $table->decimal('i_search_revenue_sharing', 32, 15)->default(0);
            $table->decimal('i_search_revenue_sharing_mg', 32, 15)->default(0);
            $table->decimal('c_search_revenue_per_1k_mau', 32, 15)->default(0);
            $table->decimal('c_search_revenue_per_1k_mau_mg', 32, 15)->default(0);

            //ads revenue sharing
            $table->decimal('i_ads_revenue_sharing', 32, 15)->default(0);
            $table->decimal('i_ads_revenue_sharing_mg', 32, 15)->default(0);
            $table->decimal('c_monthly_page_view', 32, 15)->default(0);
            $table->decimal('c_monthly_page_view_mg', 32, 15)->default(0);
            $table->decimal('c_ecpm', 32, 15)->default(0);
            $table->decimal('c_ecpm_mg', 32, 15)->default(0);
            $table->decimal('c_ads_revenue_per_1k_ads_dau', 32, 15)->default(0);
            $table->decimal('c_ads_revenue_per_1k_ads_dau_mg', 32, 15)->default(0);
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
