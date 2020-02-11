<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPaymentRevenueSharingToForecastDevicesView extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('forecast_devices_view', function (Blueprint $table) {
            $table->decimal('i_c_payment_revenue_sharing', 32, 15)->default(0);
            $table->decimal('i_c_payment_revenue_sharing_mg', 32, 15)->default(0);
            $table->decimal('i_c_payment_revenue_sharing_cg', 32, 15)->default(0);

            $table->decimal('c_prs_billing_cut', 32, 15)->default(0);
            $table->decimal('c_prs_billing_cut_mg', 32, 15)->default(0);
            $table->decimal('c_prs_oem_rev_share', 32, 15)->default(0);
            $table->decimal('c_prs_oem_rev_share_mg', 32, 15)->default(0);
            $table->decimal('c_prs_carrier_rev_share', 32, 15)->default(0);
            $table->decimal('c_prs_carrier_rev_share_mg', 32, 15)->default(0);
            $table->decimal('c_prs_aggreg_rev_share', 32, 15)->default(0);
            $table->decimal('c_prs_aggreg_rev_share_mg', 32, 15)->default(0);
            $table->decimal('c_prs_aggregator_app_ratio', 32, 15)->default(0);
            $table->decimal('c_prs_aggregator_app_ratio_mg', 32, 15)->default(0);
            $table->decimal('c_prs_app_dev_or_content_provider_rev_share', 32, 15)->default(0);
            $table->decimal('c_prs_app_dev_or_content_provider_rev_share_mg', 32, 15)->default(0);
            $table->decimal('c_prs_kai_apps_prs_revenue_ratio', 32, 15)->default(0);
            $table->decimal('c_prs_kai_apps_prs_revenue_ratio_mg', 32, 15)->default(0);
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
            $table->dropColumn('i_c_payment_revenue_sharing');
            $table->dropColumn('i_c_payment_revenue_sharing_mg');
            $table->dropColumn('i_c_payment_revenue_sharing_cg');

            $table->dropColumn('c_prs_billing_cut');
            $table->dropColumn('c_prs_billing_cut_mg');
            $table->dropColumn('c_prs_oem_rev_share');
            $table->dropColumn('c_prs_oem_rev_share_mg');
            $table->dropColumn('c_prs_carrier_rev_share');
            $table->dropColumn('c_prs_carrier_rev_share_mg');
            $table->dropColumn('c_prs_aggreg_rev_share');
            $table->dropColumn('c_prs_aggreg_rev_share_mg');
            $table->dropColumn('c_prs_aggregator_app_ratio');
            $table->dropColumn('c_prs_aggregator_app_ratio_mg');
            $table->dropColumn('c_prs_app_dev_or_content_provider_rev_share');
            $table->dropColumn('c_prs_app_dev_or_content_provider_rev_share_mg');
            $table->dropColumn('c_prs_kai_apps_prs_revenue_ratio');
            $table->dropColumn('c_prs_kai_apps_prs_revenue_ratio_mg');
        });
    }
}
