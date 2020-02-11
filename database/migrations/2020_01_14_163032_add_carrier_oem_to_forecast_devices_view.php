<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCarrierOemToForecastDevicesView extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('forecast_devices_view', function (Blueprint $table) {
            $table->decimal('c_prs_aggreg_rev_share_v2', 32, 15)->default(0);
            $table->decimal('c_prs_aggreg_rev_share_mg_v2', 32, 15)->default(0);
            $table->decimal('c_prs_aggreg_app_ratio_v2', 32, 15)->default(0);
            $table->decimal('c_prs_aggreg_app_ratio_mg_v2', 32, 15)->default(0);
            $table->decimal('c_prs_app_dev_store_v2', 32, 15)->default(0);
            $table->decimal('c_prs_app_dev_store_mg_v2', 32, 15)->default(0);

            $table->decimal('c_prs_kai_app_ratio_store_v2', 32, 15)->default(0);
            $table->decimal('c_prs_kai_app_ratio_store_mg_v2', 32, 15)->default(0);
            $table->decimal('c_prs_billing_cut_store_v2', 32, 15)->default(0);
            $table->decimal('c_prs_billing_cut_store_mg_v2', 32, 15)->default(0);

            $table->decimal('c_prs_store_carrier_sharing_v2', 32, 15)->default(0);
            $table->decimal('c_prs_store_carrier_sharing_mg_v2', 32, 15)->default(0);
            $table->decimal('c_prs_store_oem_sharing_v2', 32, 15)->default(0);
            $table->decimal('c_prs_store_oem_sharing_mg_v2', 32, 15)->default(0);

            $table->decimal('c_prs_store_carrier_sharing_v1', 32, 15)->default(0);
            $table->decimal('c_prs_store_carrier_sharing_mg_v1', 32, 15)->default(0);
            $table->decimal('c_prs_store_oem_sharing_v1', 32, 15)->default(0);
            $table->decimal('c_prs_store_oem_sharing_mg_v1', 32, 15)->default(0);

            $table->decimal('c_prs_carrier_sharing_iap', 32, 15)->default(0);
            $table->decimal('c_prs_carrier_sharing_mg_iap', 32, 15)->default(0);
            $table->decimal('c_prs_oem_sharing_iap', 32, 15)->default(0);
            $table->decimal('c_prs_oem_sharing_mg_iap', 32, 15)->default(0);

            $table->decimal('c_prs_aggrev_rev_share_iap', 32, 15)->default(0);
            $table->decimal('c_prs_aggrev_rev_share_iap_mg', 32, 15)->default(0);
            $table->decimal('c_prs_aggregator_app_ratio_iap', 32, 15)->default(0);
            $table->decimal('c_prs_aggregator_app_ratio_iap_mg', 32, 15)->default(0);
            $table->decimal('c_prs_app_dev_or_content_provider_rev_share_iap', 32, 15)->default(0);
            $table->decimal('c_prs_app_dev_or_content_provider_rev_share_iap_mg', 32, 15)->default(0);
            $table->decimal('c_prs_apps_payment_revenue_ratio_iap', 32, 15)->default(0);
            $table->decimal('c_prs_apps_payment_revenue_ratio_iap_mg', 32, 15)->default(0);
            $table->decimal('c_prs_billing_cut_iap', 32, 15)->default(0);
            $table->decimal('c_prs_billing_cut_iap_mg', 32, 15)->default(0);
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

            $table->dropColumn('c_prs_aggreg_rev_share_v2');
            $table->dropColumn('c_prs_aggreg_rev_share_mg_v2');
            $table->dropColumn('c_prs_aggreg_app_ratio_v2');
            $table->dropColumn('c_prs_aggreg_app_ratio_mg_v2');
            $table->dropColumn('c_prs_app_dev_store_v2');
            $table->dropColumn('c_prs_app_dev_store_mg_v2');

            $table->dropColumn('c_prs_kai_app_ratio_store_v2');
            $table->dropColumn('c_prs_kai_app_ratio_store_mg_v2');
            $table->dropColumn('c_prs_billing_cut_store_v2');
            $table->dropColumn('c_prs_billing_cut_store_mg_v2');

            $table->dropColumn('c_prs_store_carrier_sharing_v2');
            $table->dropColumn('c_prs_store_carrier_sharing_mg_v2');
            $table->dropColumn('c_prs_store_oem_sharing_v2');
            $table->dropColumn('c_prs_store_oem_sharing_mg_v2');

            $table->dropColumn('c_prs_store_carrier_sharing_v1');
            $table->dropColumn('c_prs_store_carrier_sharing_mg_v1');
            $table->dropColumn('c_prs_store_oem_sharing_v1');
            $table->dropColumn('c_prs_store_oem_sharing_mg_v1');

            $table->dropColumn('c_prs_carrier_sharing_iap');
            $table->dropColumn('c_prs_carrier_sharing_mg_iap');
            $table->dropColumn('c_prs_oem_sharing_iap');
            $table->dropColumn('c_prs_oem_sharing_mg_iap');

            $table->dropColumn('c_prs_aggrev_rev_share_iap');
            $table->dropColumn('c_prs_aggrev_rev_share_iap_mg');
            $table->dropColumn('c_prs_aggregator_app_ratio_iap');
            $table->dropColumn('c_prs_aggregator_app_ratio_iap_mg');
            $table->dropColumn('c_prs_app_dev_or_content_provider_rev_share_iap');
            $table->dropColumn('c_prs_app_dev_or_content_provider_rev_share_iap_mg');
            $table->dropColumn('c_prs_apps_payment_revenue_ratio_iap');
            $table->dropColumn('c_prs_apps_payment_revenue_ratio_iap_mg');
            $table->dropColumn('c_prs_billing_cut_iap');
            $table->dropColumn('c_prs_billing_cut_iap_mg');
        });
    }
}
