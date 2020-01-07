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
            $table->decimal('i_shipment_cg', 32, 15)->default(0);
            $table->decimal('i_shipment', 32, 15)->default(0);
            $table->decimal('i_shipment_mg', 32, 15)->default(0);

            $table->decimal('c_shipment', 32, 15)->default(0);
            $table->decimal('c_shipment_mg', 32, 15)->default(0);

            //install base
            $table->decimal('i_install_base_cg', 32, 15)->default(0);
            $table->decimal('i_install_base', 32, 15)->default(0);
            $table->decimal('i_install_base_mg', 32, 15)->default(0);
            $table->decimal('c_chrun_rate', 32, 15)->default(0);
            $table->decimal('c_chrun_rate_mg', 32, 15)->default(0);
            $table->integer('c_lifetime')->default(0);
            $table->decimal('c_lifetime_mg', 32, 15)->default(0);

            //activated device
            $table->decimal('i_activated_device_cg', 32, 15)->default(0);
            $table->decimal('i_activated_device', 32, 15)->default(0);
            $table->decimal('i_activated_device_mg', 32, 15)->default(0);
            $table->decimal('c_activation_ratio', 32, 15)->default(0);
            $table->decimal('c_activation_ratio_mg', 32, 15)->default(0);

            //mau
            $table->decimal('i_mau_cg', 32, 15)->default(0);
            $table->decimal('i_mau', 32, 15)->default(0);
            $table->decimal('i_mau_mg', 32, 15)->default(0);
            $table->decimal('c_initial_mau_ratio', 32, 15)->default(0);
            $table->decimal('c_initial_mau_ratio_mg', 32, 15)->default(0);
            $table->decimal('c_mau_growth_factor', 32, 15)->default(0);
            $table->decimal('c_mau_growth_factor_mg', 32, 15)->default(0);

            //ads mau
            $table->decimal('i_ads_dau', 32, 15)->default(0);
            $table->decimal('i_ads_dau_mg', 32, 15)->default(0);
            $table->decimal('i_ads_dau_cg', 32, 15)->default(0);
            $table->decimal('c_ads_dau_from_mau', 32, 15)->default(0);
            $table->decimal('c_ads_dau_from_mau_mg', 32, 15)->default(0);

            //fota fee
            $table->decimal('i_fota_fee', 32, 15)->default(0);
            $table->decimal('i_fota_fee_mg', 32, 15)->default(0);
            $table->decimal('i_fota_fee_cg', 32, 15)->default(0);
            $table->decimal('c_fota_fee', 32, 15)->default(0);
            $table->decimal('c_fota_fee_mg', 32, 15)->default(0);

            //search revenue sharing
            $table->decimal('i_search_revenue_sharing', 32, 15)->default(0);
            $table->decimal('i_search_revenue_sharing_mg', 32, 15)->default(0);
            $table->decimal('i_search_revenue_sharing_cg', 32, 15)->default(0);
            $table->decimal('c_search_revenue_per_1k_mau', 32, 15)->default(0);
            $table->decimal('c_search_revenue_per_1k_mau_mg', 32, 15)->default(0);

            //ads revenue sharing
            $table->decimal('i_ads_revenue_sharing', 32, 15)->default(0);
            $table->decimal('i_ads_revenue_sharing_mg', 32, 15)->default(0);
            $table->decimal('i_ads_revenue_sharing_cg', 32, 15)->default(0);

            $table->decimal('c_ads_monthly_page_view', 32, 15)->default(0);
            $table->decimal('c_ads_monthly_page_view_mg', 32, 15)->default(0);
            $table->decimal('c_ads_ecpm', 32, 15)->default(0);
            $table->decimal('c_ads_ecpm_mg', 32, 15)->default(0);
            $table->decimal('c_ads_revenue_per_1k_ads_dau', 32, 15)->default(0);
            $table->decimal('c_ads_revenue_per_1k_ads_dau_mg', 32, 15)->default(0);
            $table->decimal('c_ads_carrier_rev_share', 32, 15)->default(0);
            $table->decimal('c_ads_carrier_rev_share_mg', 32, 15)->default(0);
            $table->decimal('c_ads_aggreg_rev_share', 32, 15)->default(0);
            $table->decimal('c_ads_aggreg_rev_share_mg', 32, 15)->default(0);
            $table->decimal('c_ads_aggregator_app_ratio', 32, 15)->default(0);
            $table->decimal('c_ads_aggregator_app_ratio_mg', 32, 15)->default(0);
            $table->decimal('c_ads_app_dev_or_content_provider_rev_share', 32, 15)->default(0);
            $table->decimal('c_ads_app_dev_or_content_provider_rev_share_mg', 32, 15)->default(0);
            $table->decimal('c_ads_kai_apps_ads_revenue_ratio', 32, 15)->default(0);
            $table->decimal('c_ads_kai_apps_ads_revenue_ratio_mg', 32, 15)->default(0);

            // payments Revenue Sharing Store V2
            $table->decimal('i_payments_revenue_sharing_store_v2', 32, 15)->default(0);
            $table->decimal('i_payments_revenue_sharing_store_v2_mg', 32, 15)->default(0);
            $table->decimal('i_payments_revenue_sharing_store_v2_cg', 32, 15)->default(0);

            $table->decimal('c_store_average_selling_price', 32, 15)->default(0);
            $table->decimal('c_store_average_selling_price_mg', 32, 15)->default(0);
            $table->decimal('c_mau_to_store_app_view_ratio', 32, 15)->default(0);
            $table->decimal('c_mau_to_store_app_view_ratio_mg', 32, 15)->default(0);
            $table->decimal('c_kai_pay_coverage', 32, 15)->default(0);
            $table->decimal('c_kai_pay_coverage_mg', 32, 15)->default(0);
            $table->decimal('c_store_app_view_of_paid_app', 32, 15)->default(0);
            $table->decimal('c_store_app_view_of_paid_app_mg', 32, 15)->default(0);
            $table->decimal('c_conversion_to_purchase_store', 32, 15)->default(0);
            $table->decimal('c_conversion_to_purchase_store_mg', 32, 15)->default(0);


            //Payments Revenue Sharing IAP V2
            $table->decimal('i_payments_revenue_sharing_iap', 32, 15)->default(0);
            $table->decimal('i_payments_revenue_sharing_iap_mg', 32, 15)->default(0);
            $table->decimal('i_payments_revenue_sharing_iap_cg', 32, 15)->default(0);

            $table->decimal('c_oem_rev_share_iap', 32, 15)->default(0);
            $table->decimal('c_oem_rev_share_iap_mg', 32, 15)->default(0);
            $table->decimal('c_conversion_to_purchase_iap', 32, 15)->default(0);
            $table->decimal('c_conversion_to_purchase_iap_mg', 32, 15)->default(0);
            $table->decimal('c_iap_average_selling_price', 32, 15)->default(0);
            $table->decimal('c_iap_average_selling_price_mg', 32, 15)->default(0);

            //Payments Revenue Sharing
            $table->decimal('i_payments_revenue_sharing', 32, 15)->default(0);
            $table->decimal('i_payments_revenue_sharing_mg', 32, 15)->default(0);
            $table->decimal('i_payments_revenue_sharing_cg', 32, 15)->default(0);

            $table->decimal('c_oem_rev_share', 32, 15)->default(0);
            $table->decimal('c_oem_rev_share_mg', 32, 15)->default(0);
            $table->decimal('c_carrier_rev_sharing', 32, 15)->default(0);
            $table->decimal('c_carrier_rev_sharing_mg', 32, 15)->default(0);
            $table->decimal('c_aggregator_app_ratio', 32, 15)->default(0);
            $table->decimal('c_aggregator_app_ratio_mg', 32, 15)->default(0);
            $table->decimal('c_app_dev_or_content_provider_rev_share', 32, 15)->default(0);
            $table->decimal('c_app_dev_or_content_provider_rev_share_mg', 32, 15)->default(0);
            $table->decimal('c_kai_apps_payment_revenue_ratio', 32, 15)->default(0);
            $table->decimal('c_kai_apps_payment_revenue_ratio_mg', 32, 15)->default(0);
            $table->decimal('c_billing_cut', 32, 15)->default(0);
            $table->decimal('c_billing_cut_mg', 32, 15)->default(0);

            //(Revenue) 3rd Party Licenses
            $table->decimal('i_revenue_3rd_party_licenses', 32, 15)->default(0);
            $table->decimal('i_revenue_3rd_party_licenses_mg', 32, 15)->default(0);
            $table->decimal('i_revenue_3rd_party_licenses_cg', 32, 15)->default(0);

            $table->decimal('c_touchpal_licenses_fee', 32, 15)->default(0);
            $table->decimal('c_touchpal_licenses_fee_mg', 32, 15)->default(0);

            //(Cost) 3rd Party Licenses
            $table->decimal('i_cost_3rd_party_licenses', 32, 15)->default(0);
            $table->decimal('i_cost_3rd_party_licenses_mg', 32, 15)->default(0);
            $table->decimal('i_cost_3rd_party_licenses_cg', 32, 15)->default(0);

            $table->decimal('c_touchpal_licenses_cost', 32, 15)->default(0);
            $table->decimal('c_touchpal_licenses_cost_mg', 32, 15)->default(0);

            //(Revenue) Maintenance
            $table->decimal('i_maintenance', 32, 15)->default(0);
            $table->decimal('i_maintenance_mg', 32, 15)->default(0);
            $table->decimal('i_maintenance_cg', 32, 15)->default(0);

            $table->decimal('c_yearly_maintenance_price', 32, 15)->default(0);
            $table->decimal('c_yearly_maintenance_price_mg', 32, 15)->default(0);

            //(Revenue) NRE
            $table->decimal('i_nre', 32, 15)->default(0);
            $table->decimal('i_nre_mg', 32, 15)->default(0);
            $table->decimal('i_nre_cg', 32, 15)->default(0);

            $table->decimal('c_monthly_team_price', 32, 15)->default(0);
            $table->decimal('c_monthly_team_price_mg', 32, 15)->default(0);

            //(Revenue) App Preload
            $table->decimal('i_app_preload', 32, 15)->default(0);
            $table->decimal('i_app_preload_mg', 32, 15)->default(0);
            $table->decimal('i_app_preload_cg', 32, 15)->default(0);

            $table->decimal('c_placement_fee_carrier', 32, 15)->default(0);
            $table->decimal('c_placement_fee_carrier_mg', 32, 15)->default(0);
            $table->decimal('c_preload_app_act_rate_carrier', 32, 15)->default(0);
            $table->decimal('c_preload_app_act_rate_carrier_mg', 32, 15)->default(0);
            $table->decimal('c_placement_fee_om', 32, 15)->default(0);
            $table->decimal('c_placement_fee_om_mg', 32, 15)->default(0);
            $table->decimal('c_preload_app_act_rate_om', 32, 15)->default(0);
            $table->decimal('c_preload_app_act_rate_om_mg', 32, 15)->default(0);

            //(Revenue) Carrier tab fee
            $table->decimal('i_carrier_tab_fee', 32, 15)->default(0);
            $table->decimal('i_carrier_tab_fee_mg', 32, 15)->default(0);
            $table->decimal('i_carrier_tab_fee_cg', 32, 15)->default(0);

            $table->decimal('c_carrier_tab_fee_carrier', 32, 15)->default(0);
            $table->decimal('c_carrier_tab_fee_carrier_mg', 32, 15)->default(0);
            $table->decimal('c_carrier_tab_fee_om', 32, 15)->default(0);
            $table->decimal('c_carrier_tab_fee_om_mg', 32, 15)->default(0);

            //(Revenue) Yearly App Preload/Placement Fee
            $table->decimal('i_yearly_app_preload', 32, 15)->default(0);
            $table->decimal('i_yearly_app_preload_mg', 32, 15)->default(0);
            $table->decimal('i_yearly_app_preload_cg', 32, 15)->default(0);

            $table->decimal('c_yearly_placement_fee', 32, 15)->default(0);
            $table->decimal('c_yearly_placement_fee_mg', 32, 15)->default(0);

            //(Revenue) Device Financing
            $table->decimal('i_r_device_financing', 32, 15)->default(0);
            $table->decimal('i_r_device_financing_mg', 32, 15)->default(0);
            $table->decimal('i_r_device_financing_cg', 32, 15)->default(0);

            $table->decimal('c_df_kim_fee', 32, 15)->default(0);
            $table->decimal('c_df_kim_fee_mg', 32, 15)->default(0);
            $table->decimal('c_df_monthly_chrun_rate', 32, 15)->default(0);
            $table->decimal('c_df_monthly_chrun_rate_mg', 32, 15)->default(0);
            $table->decimal('c_df_contract_period', 32, 15)->default(0);
            $table->decimal('c_df_contract_period_mg', 32, 15)->default(0);

            //(Cost) Device Financing
            $table->decimal('i_c_device_financing', 32, 15)->default(0);
            $table->decimal('i_c_device_financing_mg', 32, 15)->default(0);
            $table->decimal('i_c_device_financing_cg', 32, 15)->default(0);

            $table->decimal('c_df_cost', 32, 15)->default(0);
            $table->decimal('c_df_cost_mg', 32, 15)->default(0);

            //(Revenue) mPost Device Management Fee
            $table->decimal('i_mpos_device_manage_fee', 32, 15)->default(0);
            $table->decimal('i_mpos_device_manage_fee_mg', 32, 15)->default(0);
            $table->decimal('i_mpos_device_manage_fee_cg', 32, 15)->default(0);

            $table->decimal('c_mpos_activation_ratio', 32, 15)->default(0);
            $table->decimal('c_mpos_activation_ratio_mg', 32, 15)->default(0);
            $table->decimal('c_mpos_monthly_fee', 32, 15)->default(0);
            $table->decimal('c_mpos_monthly_fee_mg', 32, 15)->default(0);

            //(Revenue) Promotion Fee
            $table->decimal('i_promotion_fee', 32, 15)->default(0);
            $table->decimal('i_promotion_fee_mg', 32, 15)->default(0);
            $table->decimal('i_promotion_fee_cg', 32, 15)->default(0);

            $table->decimal('c_promotion_fee', 32, 15)->default(0);
            $table->decimal('c_promotion_fee_mg', 32, 15)->default(0);

            //(Revenue) New Account registration revenue sharing
            $table->decimal('i_r_narrs', 32, 15)->default(0);
            $table->decimal('i_r_narrs_mg', 32, 15)->default(0);
            $table->decimal('i_r_narrs_cg', 32, 15)->default(0);

            $table->decimal('c_r_narrs', 32, 15)->default(0);
            $table->decimal('c_r_narrs_mg', 32, 15)->default(0);

            //(Cost) New Account registration revenue sharing
            $table->decimal('i_c_narrs', 32, 15)->default(0);
            $table->decimal('i_c_narrs_mg', 32, 15)->default(0);
            $table->decimal('i_c_narrs_cg', 32, 15)->default(0);

            $table->decimal('c_c_narrs', 32, 15)->default(0);
            $table->decimal('c_c_narrs_mg', 32, 15)->default(0);

            //(Revenue) Monthly subscription revenue sharing
            $table->decimal('i_r_msrs', 32, 15)->default(0);
            $table->decimal('i_r_msrs_mg', 32, 15)->default(0);
            $table->decimal('i_r_msrs_cg', 32, 15)->default(0);

            $table->decimal('c_r_msrs', 32, 15)->default(0);
            $table->decimal('c_r_msrs_mg', 32, 15)->default(0);

            //(Cost) Monthly subscription revenue sharing
            $table->decimal('i_c_msrs', 32, 15)->default(0);
            $table->decimal('i_c_msrs_mg', 32, 15)->default(0);
            $table->decimal('i_C_msrs_cg', 32, 15)->default(0);

            $table->decimal('c_c_msrs', 32, 15)->default(0);
            $table->decimal('c_c_msrs_mg', 32, 15)->default(0);

            //(Revenue) Data Retail Revenue Sharing
            $table->decimal('i_data_retial_sharing', 32, 15)->default(0);
            $table->decimal('i_data_retial_sharing_mg', 32, 15)->default(0);
            $table->decimal('i_data_retial_sharing_cg', 32, 15)->default(0);

            $table->decimal('c_data_retial_sharing', 32, 15)->default(0);
            $table->decimal('c_data_retial_sharing_mg', 32, 15)->default(0);

            //(Cost) Billing Cost
            $table->decimal('i_billing_cost', 32, 15)->default(0);
            $table->decimal('i_billing_cost_mg', 32, 15)->default(0);
            $table->decimal('i_billing_cost_cg', 32, 15)->default(0);

            $table->decimal('c_vat', 32, 15)->default(0);
            $table->decimal('c_vat_mg', 32, 15)->default(0);
            $table->decimal('c_witholding_taxes', 32, 15)->default(0);
            $table->decimal('c_witholding_taxes_mg', 32, 15)->default(0);

            //(Cost) Avertisement platform
            $table->decimal('i_avertisement_platform', 32, 15)->default(0);
            $table->decimal('i_avertisement_platform_mg', 32, 15)->default(0);
            $table->decimal('i_avertisement_platform_cg', 32, 15)->default(0);

            $table->decimal('c_avertisement_platform_cost', 32, 15)->default(0);
            $table->decimal('c_avertisement_platform_cost_mg', 32, 15)->default(0);

            //(Cost) FOTA (Cloud)
            $table->decimal('i_fota_cloud', 32, 15)->default(0);
            $table->decimal('i_fota_cloud_mg', 32, 15)->default(0);
            $table->decimal('i_fota_cloud_cg', 32, 15)->default(0);

            $table->decimal('c_fota_cloud', 32, 15)->default(0);
            $table->decimal('c_fota_cloud_mg', 32, 15)->default(0);

            //(Cost) Store (Cloud)
            $table->decimal('i_store_cloud', 32, 15)->default(0);
            $table->decimal('i_store_cloud_mg', 32, 15)->default(0);
            $table->decimal('i_store_cloud_cg', 32, 15)->default(0);

            $table->decimal('c_store_cloud', 32, 15)->default(0);
            $table->decimal('c_store_cloud_mg', 32, 15)->default(0);

            //(Cost) Push (Cloud)
            $table->decimal('i_push_cloud', 32, 15)->default(0);
            $table->decimal('i_push_cloud_mg', 32, 15)->default(0);
            $table->decimal('i_push_cloud_cg', 32, 15)->default(0);

            $table->decimal('c_push_cloud', 32, 15)->default(0);
            $table->decimal('c_push_cloud_mg', 32, 15)->default(0);

            //(Cost) PTU (SMS)
            $table->decimal('i_ptu_sms', 32, 15)->default(0);
            $table->decimal('i_ptu_sms_mg', 32, 15)->default(0);
            $table->decimal('i_ptu_sms_cg', 32, 15)->default(0);

            $table->decimal('c_ptu_sms', 32, 15)->default(0);
            $table->decimal('c_ptu_sms_mg', 32, 15)->default(0);

            //(Revenue) Fota royalty
            $table->decimal('i_fota_royalty', 32, 15)->default(0);
            $table->decimal('i_fota_royalty_mg', 32, 15)->default(0);
            $table->decimal('i_fota_royalty_cg', 32, 15)->default(0);

            $table->decimal('c_fota_royalty_fee', 32, 15)->default(0);
            $table->decimal('c_fota_royalty_fee_mg', 32, 15)->default(0);


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
