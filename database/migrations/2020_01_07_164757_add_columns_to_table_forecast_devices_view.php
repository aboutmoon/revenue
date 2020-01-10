<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToTableForecastDevicesView extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('forecast_devices_view', function (Blueprint $table) {
            //ads revenue sharing
            $table->decimal('i_c_ads_revenue_sharing', 32, 15)->default(0);
            $table->decimal('i_c_ads_revenue_sharing_mg', 32, 15)->default(0);
            $table->decimal('i_c_ads_revenue_sharing_cg', 32, 15)->default(0);

            $table->decimal('c_ads_oem_rev_share', 32, 15)->default(0);
            $table->decimal('c_ads_oem_rev_share_mg', 32, 15)->default(0);

            //payments revenue sharing store v1
            $table->decimal('i_payments_revenue_sharing_store_v1', 32, 15)->default(0);
            $table->decimal('i_payments_revenue_sharing_store_v1_mg', 32, 15)->default(0);
            $table->decimal('i_payments_revenue_sharing_store_v1_cg', 32, 15)->default(0);

            $table->decimal('c_store_average_selling_price_v1', 32, 15)->default(0);
            $table->decimal('c_store_average_selling_price_v1_mg', 32, 15)->default(0);
            $table->decimal('c_mau_to_store_app_view_ratio_v1', 32, 15)->default(0);
            $table->decimal('c_mau_to_store_app_view_ratio_v1_mg', 32, 15)->default(0);
            $table->decimal('c_kai_pay_coverage_v1', 32, 15)->default(0);
            $table->decimal('c_kai_pay_coverage_v1_mg', 32, 15)->default(0);
            $table->decimal('c_store_app_view_of_paid_app_v1', 32, 15)->default(0);
            $table->decimal('c_store_app_view_of_paid_app_v1_mg', 32, 15)->default(0);
            $table->decimal('c_conversion_to_purchase_store_v1', 32, 15)->default(0);
            $table->decimal('c_conversion_to_purchase_store_v1_mg', 32, 15)->default(0);
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
            $table->dropColumn('i_ads_revenue_sharing');
            $table->dropColumn('i_ads_revenue_sharing_mg');
            $table->dropColumn('i_ads_revenue_sharing_cg');
        });
    }
}
