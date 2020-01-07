<?php

use Illuminate\Database\Seeder;
use App\Models\ForecastItem;
use App\Models\ForecastItemItem;
use App\Models\ForecastItemAccount;
use App\Models\ForecastItemLocation;
use App\Models\ForecastCriteria;
use App\Models\ForecastCriteriaLocation;
use App\Models\ForecastCriteriaParameter;

const I_SHIPMENT = 2;
const C_SHIPMENT = 1;

const I_INSTALL_BASE = 3;
const C_CHURN_RATE = 2;
const C_DEVICE_LIFETIME = 3;

const I_ACTIVATED_DEVICE = 4;
const C_ACTIVATION_RATIO = 4;

const I_MAU = 5;
const C_INITIAL_MAU_RATIO = 5;
const C_MAU_GROWTH_FACTOR = 6;

const I_ADS_MAU = 6;
const C_ADS_DAU_FROM_MAU = 7;

const I_FOTA_FEE = 8;
const C_FOTA_FEE = 8;

const I_SEARCH_REVENUE_SHARING = 10;
const C_SEARCH_REVENUE_PER_1K_MAU = 10;

const I_ADS_REVENUE_SHARING = 11;
const C_MONTHLY_PAGE_VIEW = 11;
const C_ECPM = 12;
const C_ADS_REVENUE_PER_1K_ADS_DAU = 13;

const I_PAYMENTS_REVENUE_SHARING_STORE_V2 = 13;
const C_AVERATE_SELLING_PRICE_STORE_ASP = 25;
const C_MAU_TO_STORE_APP_VIEW_RATIO = 26;
const C_KAIPAY_COVERAGE = 27;
const C_STORE_APP_VIEW_OF_PAID_APP = 28;
const C_CONVERSION_TO_PURCHASE_STORE = 29;

const I_PAYMENTS_REVENUE_SHARING_IAP_V2 = 14;
const C_APPS_WITH_IAP_RATIO = 30;
const C_CONVERSION_TO_PURCHASE_IAP = 31;
const C_AVERAGE_SELLING_PRICE_IAP = 32;

const I_PAYMENTS_REVENUE_SHARING = 15;
CONST C_OEM_REV_SHARE = 33;
CONST C_CARRIER_REV_SHARE = 34;
CONST C_AGGREG_REV_SHARE = 35;
CONST C_AGGREGATOR_APP_RATIO = 36;
CONST C_APP_DEV_OR_CONTENT_PROVIDER_REV_SHARE = 37;
CONST C_KAI_APPS_PAYMENT_REVENUE_RATIO = 38;
CONST C_BILLING_CUT = 39;

CONST I_REVENUE_3RD_PARTY_LICENSES = 16;
CONST C_TOUCHPAL_LICESES_FEE = 40;

CONST I_COST_3RD_PARTY_LICENSES = 18;
CONST C_TOUCHPAL_LICENSES_COST = 41;

CONST I_MAINTENANCE = 19;
CONST C_YEARLY_MAINTENANCE_PRICE = 42;

CONST I_NRE = 20;
CONST C_MONTHLY_TEAM_PRICE = 43;

CONST I_APP_PRELOAD = 21;
CONST C_PLACEMENT_FEE_CARRIER = 44;
CONST C_PRELOAD_APP_ACTIVATION_RATE_CARRIER = 45;
CONST C_PLACEMENT_FEE_OPEN_MARKET = 46;
CONST C_PRELOAD_APP_ACTIVATION_RATE_OPEN_MARKET = 47;

CONST I_CARRIER_TAB_FEE = 22;
CONST C_CARRIER_TAB_FEE_CARRIER = 48;
CONST C_CARRIER_TAB_FEE_OPEN_MARKET = 49;

CONST I_YEARLY_APP_PRELOAD = 23;
CONST C_YEARLY_PLACEMENT_FEE = 50;

CONST I_R_DEVICE_FINANCING = 24;
CONST C_KTM_FEE = 51;
CONST C_CONTRACT_PERIOD = 52;
CONST C_MONTHLY_CHRUN_RATE = 53;

CONST I_C_DEVICE_FINANCING = 25;
CONST C_DEVICE_FINANCE_COST = 54;

CONST I_MPOS_DEVICE_MANAGEMENT_FEE = 26;
CONST C_MPOS_ACTIVATION_RATIO = 55;
CONST C_POS_MONTHLY_FEE = 56;

CONST I_R_PROMOTION_FEE = 27;
CONST C_PROMOTION_FEE = 58;

CONST I_R_NEW_ACCOUNT_REGISTRATION_REVENUE_SHARING = 28;
CONST C_R_NEW_ACCOUNT_REGISTRATION_REVENUE_SHARING = 58;

CONST I_C_NEW_ACCOUNT_REGISTRATION_REVENUE_SHARING = 29;
CONST C_C_NEW_ACCOUNT_REGISTRATION_REVENUE_SHARING = 59;

CONST I_R_MONTHLY_SUBSCRIPTION_REVENUE_SHARING = 30;
CONST C_R_MONTHLY_SUBSCRIPTION_REVENUE_SHARING = 60;

CONST I_C_MONTHLY_SUBSCRIPTION_REVENUE_SHARING = 31;
CONST C_C_MONTHLY_SUBSCRIPTION_REVENUE_SHARING = 61;

CONST I_DATA_RETAIL_REVENUE_SHARING = 32;
CONST C_DATA_RETAIL_REVENUE_SHARING = 62;

CONST I_BILLING_COST = 33;
CONST C_VAT = 63;
CONST C_WITHOLDING_TAXES = 64;

CONST I_AVERTISEMENT_PLATFORM = 34;
CONST C_AVERTISEMENT_PLATFORM_COST = 65;

CONST I_FOTA_CLOUD = 35;
CONST C_FOTA_COST = 66;

CONST I_STORE_CLOUD = 36;
CONST C_STORE_COST = 67;

CONST I_PUSH_CLOUD = 37;
CONST C_PUSH_CLOUD = 68;

CONST I_FTU_SMS = 38;
CONST C_SMS_COST = 69;

class ForecastItemTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $markets = \App\Models\Location::where('level_type', 'Market')->get()->keyBy('name');
        $global = $markets['Global']->id;
        $emerging = $markets['Emerging Markets']->id;
        $europe = $markets['Europe/Russia']->id;
        $america = $markets['North America']->id;
        $india = $markets['India']->id;

        //shipment
        $this->shipment($global, $emerging, $europe, $america, $india);

        //install base
        $this->install_base($global, $emerging, $europe, $america, $india);

        //active_device
        $this->active_device($global, $emerging, $europe, $america, $india);

        //mau
        $this->mau($global, $emerging, $europe, $america, $india);

        //ads mau
        $this->ads_mau($global, $emerging, $europe, $america, $india);

        //fota fee
        $this->fota_fee($global, $emerging, $europe, $america, $india);

        //search_revenue_sharing
        $this->search_revenue_sharing($global, $emerging, $europe, $america, $india);

        //ads revenue sharing
        $this->ads_revenue_sharing($global, $emerging, $europe, $america, $india);

//        $this->fota_royalty($global, $emerging, $europe, $america, $india);
//
//        $this->payment_revenue_sharing_v2($global, $emerging, $europe, $america, $india);
//
//        $this->payment_revenue_sharing_iap_v2($global, $emerging, $europe, $america, $india);
//
//        $this->payment_revenue_sharing($global, $emerging, $europe, $america, $india);
//
//        $this->revenue_3rd_party_licenses($global, $emerging, $europe, $america, $india);
//
//        $this->cost_3rd_party_licenses($global, $emerging, $europe, $america, $india);
//
//        $this->maintenance($global, $emerging, $europe, $america, $india);
//
//        $this->nre($global, $emerging, $europe, $america, $india);
//
//        $this->app_preload($global, $emerging, $europe, $america, $india);
//
//        $this->carrier_tab_fee($global, $emerging, $europe, $america, $india);
//
//        $this->yearly_app_preload($global, $emerging, $europe, $america, $india);
//
//        $this->revenue_device_financing($global, $emerging, $europe, $america, $india);
//
//        $this->cost_device_financing($global, $emerging, $europe, $america, $india);
//
//        $this->mpos_device_management_fee($global, $emerging, $europe, $america, $india);
//
//        $this->promotion_fee($global, $emerging, $europe, $america, $india);
//
//        $this->revenue_new_account_registration_sharing($global, $emerging, $europe, $america, $india);
//
//        $this->cost_new_account_registration_sharing($global, $emerging, $europe, $america, $india);
//
//        $this->revenue_monthly_subscription_sharing($global, $emerging, $europe, $america, $india);
//
//        $this->cost_monthly_subscription_sharing($global, $emerging, $europe, $america, $india);
//
//        $this->date_retial_revenue_sharing($global, $emerging, $europe, $america, $india);
//
//
//        $this->cost_billing_cost($global, $emerging, $europe, $america, $india);
//
//        $this->avertisement_platform($global, $emerging, $europe, $america, $india);
//
//        $this->fota_cloud($global, $emerging, $europe, $america, $india);
//
//        $this->store_cloud($global, $emerging, $europe, $america, $india);
//
//        $this->push_cloud($global, $emerging, $europe, $america, $india);
//
//        $this->ptu_sms($global, $emerging, $europe, $america, $india);
    }

    public function ptu_sms($global, $emerging, $europe, $america, $india) {
        $id = 38;

        $revenue = 69;

        $Item = ForecastItem::create(['model_id' => 1, 'model_vid' => 1, 'date_from' => '2017-01-01', 'date_to' => '2020-12-1','coverage' => 1, 'monthly_growth' => 0]);

        ForecastItemItem::create(['id' => $Item->id, 'item_id' => $id]);
        ForecastItemLocation::create(['id' => $Item->id, 'location_id' => $global]); // Global
        ForecastItemLocation::create(['id' => $Item->id, 'location_id' => $emerging]); // Emerging Markets
        ForecastItemLocation::create(['id' => $Item->id, 'location_id' => $europe]); // Europe/Russia
        ForecastItemLocation::create(['id' => $Item->id, 'location_id' => $america]); // North America
        ForecastItemLocation::create(['id' => $Item->id, 'location_id' => $india]); // India

        $itemCriteria = ForecastCriteria::create(['model_id' => 1, 'model_vid' => 1,'item_id' => $id]);
        ForecastCriteriaLocation::create(['id' => $itemCriteria->id, 'location_id' => $emerging]);
        ForecastCriteriaLocation::create(['id' => $itemCriteria->id, 'location_id' => $europe]);
        ForecastCriteriaLocation::create(['id' => $itemCriteria->id, 'location_id' => $india]);
        ForecastCriteriaLocation::create(['id' => $itemCriteria->id, 'location_id' => $global]);
        ForecastCriteriaLocation::create(['id' => $itemCriteria->id, 'location_id' => $america]);
        ForecastCriteriaParameter::create(['value' => 0.2, 'monthly_growth' => 0,'criteria_id' => $revenue,'forecast_criteria_id' => $itemCriteria->id,  'date_from' => '2017-01-01', 'date_to' => '2020-12-01']);
    }

    public function push_cloud($global, $emerging, $europe, $america, $india) {
        $id = 37;

        $revenue = 68;

        $Item = ForecastItem::create(['model_id' => 1, 'model_vid' => 1, 'date_from' => '2017-01-01', 'date_to' => '2020-12-1','coverage' => 1, 'monthly_growth' => 0]);

        ForecastItemItem::create(['id' => $Item->id, 'item_id' => $id]);
        ForecastItemLocation::create(['id' => $Item->id, 'location_id' => $global]); // Global
        ForecastItemLocation::create(['id' => $Item->id, 'location_id' => $emerging]); // Emerging Markets
        ForecastItemLocation::create(['id' => $Item->id, 'location_id' => $europe]); // Europe/Russia
        ForecastItemLocation::create(['id' => $Item->id, 'location_id' => $america]); // North America
        ForecastItemLocation::create(['id' => $Item->id, 'location_id' => $india]); // India

        $itemCriteria = ForecastCriteria::create(['model_id' => 1, 'model_vid' => 1,'item_id' => $id]);
        ForecastCriteriaLocation::create(['id' => $itemCriteria->id, 'location_id' => $emerging]);
        ForecastCriteriaLocation::create(['id' => $itemCriteria->id, 'location_id' => $europe]);
        ForecastCriteriaLocation::create(['id' => $itemCriteria->id, 'location_id' => $india]);
        ForecastCriteriaLocation::create(['id' => $itemCriteria->id, 'location_id' => $global]);
        ForecastCriteriaLocation::create(['id' => $itemCriteria->id, 'location_id' => $america]);
        ForecastCriteriaParameter::create(['value' => 0.2, 'monthly_growth' => 0,'criteria_id' => $revenue,'forecast_criteria_id' => $itemCriteria->id,  'date_from' => '2017-01-01', 'date_to' => '2020-12-01']);
    }

    public function store_cloud($global, $emerging, $europe, $america, $india) {
        $id = 36;

        $revenue = 67;

        $Item = ForecastItem::create(['model_id' => 1, 'model_vid' => 1, 'date_from' => '2017-01-01', 'date_to' => '2020-12-1','coverage' => 1, 'monthly_growth' => 0]);

        ForecastItemItem::create(['id' => $Item->id, 'item_id' => $id]);
        ForecastItemLocation::create(['id' => $Item->id, 'location_id' => $global]); // Global
        ForecastItemLocation::create(['id' => $Item->id, 'location_id' => $emerging]); // Emerging Markets
        ForecastItemLocation::create(['id' => $Item->id, 'location_id' => $europe]); // Europe/Russia
        ForecastItemLocation::create(['id' => $Item->id, 'location_id' => $america]); // North America
        ForecastItemLocation::create(['id' => $Item->id, 'location_id' => $india]); // India

        $itemCriteria = ForecastCriteria::create(['model_id' => 1, 'model_vid' => 1,'item_id' => $id]);
        ForecastCriteriaLocation::create(['id' => $itemCriteria->id, 'location_id' => $emerging]);
        ForecastCriteriaLocation::create(['id' => $itemCriteria->id, 'location_id' => $europe]);
        ForecastCriteriaLocation::create(['id' => $itemCriteria->id, 'location_id' => $india]);
        ForecastCriteriaLocation::create(['id' => $itemCriteria->id, 'location_id' => $global]);
        ForecastCriteriaLocation::create(['id' => $itemCriteria->id, 'location_id' => $america]);
        ForecastCriteriaParameter::create(['value' => 0.2, 'monthly_growth' => 0,'criteria_id' => $revenue,'forecast_criteria_id' => $itemCriteria->id,  'date_from' => '2017-01-01', 'date_to' => '2020-12-01']);
    }

    public function fota_cloud($global, $emerging, $europe, $america, $india) {
        $id = 35;

        $revenue = 66;

        $Item = ForecastItem::create(['model_id' => 1, 'model_vid' => 1, 'date_from' => '2017-01-01', 'date_to' => '2020-12-1','coverage' => 1, 'monthly_growth' => 0]);

        ForecastItemItem::create(['id' => $Item->id, 'item_id' => $id]);
        ForecastItemLocation::create(['id' => $Item->id, 'location_id' => $global]); // Global
        ForecastItemLocation::create(['id' => $Item->id, 'location_id' => $emerging]); // Emerging Markets
        ForecastItemLocation::create(['id' => $Item->id, 'location_id' => $europe]); // Europe/Russia
        ForecastItemLocation::create(['id' => $Item->id, 'location_id' => $america]); // North America
        ForecastItemLocation::create(['id' => $Item->id, 'location_id' => $india]); // India

        $itemCriteria = ForecastCriteria::create(['model_id' => 1, 'model_vid' => 1,'item_id' => $id]);
        ForecastCriteriaLocation::create(['id' => $itemCriteria->id, 'location_id' => $emerging]);
        ForecastCriteriaLocation::create(['id' => $itemCriteria->id, 'location_id' => $europe]);
        ForecastCriteriaLocation::create(['id' => $itemCriteria->id, 'location_id' => $india]);
        ForecastCriteriaLocation::create(['id' => $itemCriteria->id, 'location_id' => $global]);
        ForecastCriteriaLocation::create(['id' => $itemCriteria->id, 'location_id' => $america]);
        ForecastCriteriaParameter::create(['value' => 0.2, 'monthly_growth' => 0,'criteria_id' => $revenue,'forecast_criteria_id' => $itemCriteria->id,  'date_from' => '2017-01-01', 'date_to' => '2020-12-01']);
    }

    public function avertisement_platform($global, $emerging, $europe, $america, $india) {
        $id = 34;

        $revenue = 65;

        $Item = ForecastItem::create(['model_id' => 1, 'model_vid' => 1, 'date_from' => '2017-01-01', 'date_to' => '2020-12-1','coverage' => 1, 'monthly_growth' => 0]);

        ForecastItemItem::create(['id' => $Item->id, 'item_id' => $id]);
        ForecastItemLocation::create(['id' => $Item->id, 'location_id' => $global]); // Global
        ForecastItemLocation::create(['id' => $Item->id, 'location_id' => $emerging]); // Emerging Markets
        ForecastItemLocation::create(['id' => $Item->id, 'location_id' => $europe]); // Europe/Russia
        ForecastItemLocation::create(['id' => $Item->id, 'location_id' => $america]); // North America
        ForecastItemLocation::create(['id' => $Item->id, 'location_id' => $india]); // India

        $itemCriteria = ForecastCriteria::create(['model_id' => 1, 'model_vid' => 1,'item_id' => $id]);
        ForecastCriteriaLocation::create(['id' => $itemCriteria->id, 'location_id' => $emerging]);
        ForecastCriteriaLocation::create(['id' => $itemCriteria->id, 'location_id' => $europe]);
        ForecastCriteriaLocation::create(['id' => $itemCriteria->id, 'location_id' => $india]);
        ForecastCriteriaLocation::create(['id' => $itemCriteria->id, 'location_id' => $global]);
        ForecastCriteriaLocation::create(['id' => $itemCriteria->id, 'location_id' => $america]);
        ForecastCriteriaParameter::create(['value' => 0.2, 'monthly_growth' => 0,'criteria_id' => $revenue,'forecast_criteria_id' => $itemCriteria->id,  'date_from' => '2017-01-01', 'date_to' => '2020-12-01']);
    }

    public function cost_billing_cost($global, $emerging, $europe, $america, $india) {
        $id = 33;

        $vat = 64;
        $witholding_taxes = 65;

        $Item = ForecastItem::create(['model_id' => 1, 'model_vid' => 1, 'date_from' => '2017-01-01', 'date_to' => '2020-12-1','coverage' => 1, 'monthly_growth' => 0]);

        ForecastItemItem::create(['id' => $Item->id, 'item_id' => $id]);
        ForecastItemLocation::create(['id' => $Item->id, 'location_id' => $global]); // Global
        ForecastItemLocation::create(['id' => $Item->id, 'location_id' => $emerging]); // Emerging Markets
        ForecastItemLocation::create(['id' => $Item->id, 'location_id' => $europe]); // Europe/Russia
        ForecastItemLocation::create(['id' => $Item->id, 'location_id' => $america]); // North America
        ForecastItemLocation::create(['id' => $Item->id, 'location_id' => $india]); // India

        $itemCriteria = ForecastCriteria::create(['model_id' => 1, 'model_vid' => 1,'item_id' => $id]);
        ForecastCriteriaLocation::create(['id' => $itemCriteria->id, 'location_id' => $emerging]);
        ForecastCriteriaLocation::create(['id' => $itemCriteria->id, 'location_id' => $europe]);
        ForecastCriteriaLocation::create(['id' => $itemCriteria->id, 'location_id' => $india]);
        ForecastCriteriaLocation::create(['id' => $itemCriteria->id, 'location_id' => $global]);
        ForecastCriteriaLocation::create(['id' => $itemCriteria->id, 'location_id' => $america]);
        ForecastCriteriaParameter::create(['value' => 0.2, 'monthly_growth' => 0,'criteria_id' => $vat,'forecast_criteria_id' => $itemCriteria->id,  'date_from' => '2017-01-01', 'date_to' => '2020-12-01']);
        ForecastCriteriaParameter::create(['value' => 0.2, 'monthly_growth' => 0,'criteria_id' => $witholding_taxes,'forecast_criteria_id' => $itemCriteria->id,  'date_from' => '2017-01-01', 'date_to' => '2020-12-01']);
    }

    public function date_retial_revenue_sharing($global, $emerging, $europe, $america, $india) {
        $id = 32;

        $revenue = 62;

        $Item = ForecastItem::create(['model_id' => 1, 'model_vid' => 1, 'date_from' => '2017-01-01', 'date_to' => '2020-12-1','coverage' => 1, 'monthly_growth' => 0]);

        ForecastItemItem::create(['id' => $Item->id, 'item_id' => $id]);
        ForecastItemLocation::create(['id' => $Item->id, 'location_id' => $global]); // Global
        ForecastItemLocation::create(['id' => $Item->id, 'location_id' => $emerging]); // Emerging Markets
        ForecastItemLocation::create(['id' => $Item->id, 'location_id' => $europe]); // Europe/Russia
        ForecastItemLocation::create(['id' => $Item->id, 'location_id' => $america]); // North America
        ForecastItemLocation::create(['id' => $Item->id, 'location_id' => $india]); // India

        $itemCriteria = ForecastCriteria::create(['model_id' => 1, 'model_vid' => 1,'item_id' => $id]);
        ForecastCriteriaLocation::create(['id' => $itemCriteria->id, 'location_id' => $emerging]);
        ForecastCriteriaLocation::create(['id' => $itemCriteria->id, 'location_id' => $europe]);
        ForecastCriteriaLocation::create(['id' => $itemCriteria->id, 'location_id' => $india]);
        ForecastCriteriaLocation::create(['id' => $itemCriteria->id, 'location_id' => $global]);
        ForecastCriteriaLocation::create(['id' => $itemCriteria->id, 'location_id' => $america]);
        ForecastCriteriaParameter::create(['value' => 0.2, 'monthly_growth' => 0,'criteria_id' => $revenue,'forecast_criteria_id' => $itemCriteria->id,  'date_from' => '2017-01-01', 'date_to' => '2020-12-01']);
    }

    public function cost_monthly_subscription_sharing($global, $emerging, $europe, $america, $india) {
        $id = 31;

        $revenue = 61;

        $Item = ForecastItem::create(['model_id' => 1, 'model_vid' => 1, 'date_from' => '2017-01-01', 'date_to' => '2020-12-1','coverage' => 1, 'monthly_growth' => 0]);

        ForecastItemItem::create(['id' => $Item->id, 'item_id' => $id]);
        ForecastItemLocation::create(['id' => $Item->id, 'location_id' => $global]); // Global
        ForecastItemLocation::create(['id' => $Item->id, 'location_id' => $emerging]); // Emerging Markets
        ForecastItemLocation::create(['id' => $Item->id, 'location_id' => $europe]); // Europe/Russia
        ForecastItemLocation::create(['id' => $Item->id, 'location_id' => $america]); // North America
        ForecastItemLocation::create(['id' => $Item->id, 'location_id' => $india]); // India

        $itemCriteria = ForecastCriteria::create(['model_id' => 1, 'model_vid' => 1,'item_id' => $id]);
        ForecastCriteriaLocation::create(['id' => $itemCriteria->id, 'location_id' => $emerging]);
        ForecastCriteriaLocation::create(['id' => $itemCriteria->id, 'location_id' => $europe]);
        ForecastCriteriaLocation::create(['id' => $itemCriteria->id, 'location_id' => $india]);
        ForecastCriteriaLocation::create(['id' => $itemCriteria->id, 'location_id' => $global]);
        ForecastCriteriaLocation::create(['id' => $itemCriteria->id, 'location_id' => $america]);
        ForecastCriteriaParameter::create(['value' => 0.2, 'monthly_growth' => 0,'criteria_id' => $revenue,'forecast_criteria_id' => $itemCriteria->id,  'date_from' => '2017-01-01', 'date_to' => '2020-12-01']);
    }

    public function revenue_monthly_subscription_sharing($global, $emerging, $europe, $america, $india) {
        $id = 30;

        $revenue = 60;

        $Item = ForecastItem::create(['model_id' => 1, 'model_vid' => 1, 'date_from' => '2017-01-01', 'date_to' => '2020-12-1','coverage' => 1, 'monthly_growth' => 0]);

        ForecastItemItem::create(['id' => $Item->id, 'item_id' => $id]);
        ForecastItemLocation::create(['id' => $Item->id, 'location_id' => $global]); // Global
        ForecastItemLocation::create(['id' => $Item->id, 'location_id' => $emerging]); // Emerging Markets
        ForecastItemLocation::create(['id' => $Item->id, 'location_id' => $europe]); // Europe/Russia
        ForecastItemLocation::create(['id' => $Item->id, 'location_id' => $america]); // North America
        ForecastItemLocation::create(['id' => $Item->id, 'location_id' => $india]); // India

        $itemCriteria = ForecastCriteria::create(['model_id' => 1, 'model_vid' => 1,'item_id' => $id]);
        ForecastCriteriaLocation::create(['id' => $itemCriteria->id, 'location_id' => $emerging]);
        ForecastCriteriaLocation::create(['id' => $itemCriteria->id, 'location_id' => $europe]);
        ForecastCriteriaLocation::create(['id' => $itemCriteria->id, 'location_id' => $india]);
        ForecastCriteriaLocation::create(['id' => $itemCriteria->id, 'location_id' => $global]);
        ForecastCriteriaLocation::create(['id' => $itemCriteria->id, 'location_id' => $america]);
        ForecastCriteriaParameter::create(['value' => 0.2, 'monthly_growth' => 0,'criteria_id' => $revenue,'forecast_criteria_id' => $itemCriteria->id,  'date_from' => '2017-01-01', 'date_to' => '2020-12-01']);
    }



    public function cost_new_account_registration_sharing($global, $emerging, $europe, $america, $india) {
        $id = 29;

        $revenue = 59;

        $Item = ForecastItem::create(['model_id' => 1, 'model_vid' => 1, 'date_from' => '2017-01-01', 'date_to' => '2020-12-1','coverage' => 1, 'monthly_growth' => 0]);

        ForecastItemItem::create(['id' => $Item->id, 'item_id' => $id]);
        ForecastItemLocation::create(['id' => $Item->id, 'location_id' => $global]); // Global
        ForecastItemLocation::create(['id' => $Item->id, 'location_id' => $emerging]); // Emerging Markets
        ForecastItemLocation::create(['id' => $Item->id, 'location_id' => $europe]); // Europe/Russia
        ForecastItemLocation::create(['id' => $Item->id, 'location_id' => $america]); // North America
        ForecastItemLocation::create(['id' => $Item->id, 'location_id' => $india]); // India

        $itemCriteria = ForecastCriteria::create(['model_id' => 1, 'model_vid' => 1,'item_id' => $id]);
        ForecastCriteriaLocation::create(['id' => $itemCriteria->id, 'location_id' => $emerging]);
        ForecastCriteriaLocation::create(['id' => $itemCriteria->id, 'location_id' => $europe]);
        ForecastCriteriaLocation::create(['id' => $itemCriteria->id, 'location_id' => $india]);
        ForecastCriteriaLocation::create(['id' => $itemCriteria->id, 'location_id' => $global]);
        ForecastCriteriaLocation::create(['id' => $itemCriteria->id, 'location_id' => $america]);
        ForecastCriteriaParameter::create(['value' => 0.2, 'monthly_growth' => 0,'criteria_id' => $revenue,'forecast_criteria_id' => $itemCriteria->id,  'date_from' => '2017-01-01', 'date_to' => '2020-12-01']);
    }

    public function revenue_new_account_registration_sharing($global, $emerging, $europe, $america, $india) {
        $id = 28;

        $revenue = 58;

        $Item = ForecastItem::create(['model_id' => 1, 'model_vid' => 1, 'date_from' => '2017-01-01', 'date_to' => '2020-12-1','coverage' => 1, 'monthly_growth' => 0]);

        ForecastItemItem::create(['id' => $Item->id, 'item_id' => $id]);
        ForecastItemLocation::create(['id' => $Item->id, 'location_id' => $global]); // Global
        ForecastItemLocation::create(['id' => $Item->id, 'location_id' => $emerging]); // Emerging Markets
        ForecastItemLocation::create(['id' => $Item->id, 'location_id' => $europe]); // Europe/Russia
        ForecastItemLocation::create(['id' => $Item->id, 'location_id' => $america]); // North America
        ForecastItemLocation::create(['id' => $Item->id, 'location_id' => $india]); // India

        $itemCriteria = ForecastCriteria::create(['model_id' => 1, 'model_vid' => 1,'item_id' => $id]);
        ForecastCriteriaLocation::create(['id' => $itemCriteria->id, 'location_id' => $emerging]);
        ForecastCriteriaLocation::create(['id' => $itemCriteria->id, 'location_id' => $europe]);
        ForecastCriteriaLocation::create(['id' => $itemCriteria->id, 'location_id' => $india]);
        ForecastCriteriaLocation::create(['id' => $itemCriteria->id, 'location_id' => $global]);
        ForecastCriteriaLocation::create(['id' => $itemCriteria->id, 'location_id' => $america]);
        ForecastCriteriaParameter::create(['value' => 0.2, 'monthly_growth' => 0,'criteria_id' => $revenue,'forecast_criteria_id' => $itemCriteria->id,  'date_from' => '2017-01-01', 'date_to' => '2020-12-01']);
    }

    public function promotion_fee($global, $emerging, $europe, $america, $india) {
        $id = 27;

        $mpos_activation_ratio = 57;

        $Item = ForecastItem::create(['model_id' => 1, 'model_vid' => 1, 'date_from' => '2017-01-01', 'date_to' => '2020-12-1','coverage' => 1, 'monthly_growth' => 0]);

        ForecastItemItem::create(['id' => $Item->id, 'item_id' => $id]);
        ForecastItemLocation::create(['id' => $Item->id, 'location_id' => $global]); // Global
        ForecastItemLocation::create(['id' => $Item->id, 'location_id' => $emerging]); // Emerging Markets
        ForecastItemLocation::create(['id' => $Item->id, 'location_id' => $europe]); // Europe/Russia
        ForecastItemLocation::create(['id' => $Item->id, 'location_id' => $america]); // North America
        ForecastItemLocation::create(['id' => $Item->id, 'location_id' => $india]); // India

        $itemCriteria = ForecastCriteria::create(['model_id' => 1, 'model_vid' => 1,'item_id' => $id]);
        ForecastCriteriaLocation::create(['id' => $itemCriteria->id, 'location_id' => $emerging]);
        ForecastCriteriaLocation::create(['id' => $itemCriteria->id, 'location_id' => $europe]);
        ForecastCriteriaLocation::create(['id' => $itemCriteria->id, 'location_id' => $india]);
        ForecastCriteriaLocation::create(['id' => $itemCriteria->id, 'location_id' => $global]);
        ForecastCriteriaLocation::create(['id' => $itemCriteria->id, 'location_id' => $america]);
        ForecastCriteriaParameter::create(['value' => 0.2, 'monthly_growth' => 0,'criteria_id' => $mpos_activation_ratio,'forecast_criteria_id' => $itemCriteria->id,  'date_from' => '2017-01-01', 'date_to' => '2020-12-01']);
    }

    public function mpos_device_management_fee($global, $emerging, $europe, $america, $india) {
        $id = 26;

        $mpos_activation_ratio = 55;
        $mpos_monthly_fee = 56;

        $Item = ForecastItem::create(['model_id' => 1, 'model_vid' => 1, 'date_from' => '2017-01-01', 'date_to' => '2020-12-1','coverage' => 1, 'monthly_growth' => 0]);

        ForecastItemItem::create(['id' => $Item->id, 'item_id' => $id]);
        ForecastItemLocation::create(['id' => $Item->id, 'location_id' => $global]); // Global
        ForecastItemLocation::create(['id' => $Item->id, 'location_id' => $emerging]); // Emerging Markets
        ForecastItemLocation::create(['id' => $Item->id, 'location_id' => $europe]); // Europe/Russia
        ForecastItemLocation::create(['id' => $Item->id, 'location_id' => $america]); // North America
        ForecastItemLocation::create(['id' => $Item->id, 'location_id' => $india]); // India

        $itemCriteria = ForecastCriteria::create(['model_id' => 1, 'model_vid' => 1,'item_id' => $id]);
        ForecastCriteriaLocation::create(['id' => $itemCriteria->id, 'location_id' => $emerging]);
        ForecastCriteriaLocation::create(['id' => $itemCriteria->id, 'location_id' => $europe]);
        ForecastCriteriaLocation::create(['id' => $itemCriteria->id, 'location_id' => $india]);
        ForecastCriteriaLocation::create(['id' => $itemCriteria->id, 'location_id' => $global]);
        ForecastCriteriaLocation::create(['id' => $itemCriteria->id, 'location_id' => $america]);
        ForecastCriteriaParameter::create(['value' => 0.2, 'monthly_growth' => 0,'criteria_id' => $mpos_activation_ratio,'forecast_criteria_id' => $itemCriteria->id,  'date_from' => '2017-01-01', 'date_to' => '2020-12-01']);
        ForecastCriteriaParameter::create(['value' => 0.2, 'monthly_growth' => 0,'criteria_id' => $mpos_monthly_fee,'forecast_criteria_id' => $itemCriteria->id,  'date_from' => '2017-01-01', 'date_to' => '2020-12-01']);
    }

    public function cost_device_financing($global, $emerging, $europe, $america, $india) {
        $id = 25;

        $device_finance_cost = 54;

        $Item = ForecastItem::create(['model_id' => 1, 'model_vid' => 1, 'date_from' => '2017-01-01', 'date_to' => '2020-12-1','coverage' => 1, 'monthly_growth' => 0]);

        ForecastItemItem::create(['id' => $Item->id, 'item_id' => $id]);
        ForecastItemLocation::create(['id' => $Item->id, 'location_id' => $global]); // Global
        ForecastItemLocation::create(['id' => $Item->id, 'location_id' => $emerging]); // Emerging Markets
        ForecastItemLocation::create(['id' => $Item->id, 'location_id' => $europe]); // Europe/Russia
        ForecastItemLocation::create(['id' => $Item->id, 'location_id' => $america]); // North America
        ForecastItemLocation::create(['id' => $Item->id, 'location_id' => $india]); // India

        $itemCriteria = ForecastCriteria::create(['model_id' => 1, 'model_vid' => 1,'item_id' => $id]);
        ForecastCriteriaLocation::create(['id' => $itemCriteria->id, 'location_id' => $emerging]);
        ForecastCriteriaLocation::create(['id' => $itemCriteria->id, 'location_id' => $europe]);
        ForecastCriteriaLocation::create(['id' => $itemCriteria->id, 'location_id' => $india]);
        ForecastCriteriaLocation::create(['id' => $itemCriteria->id, 'location_id' => $global]);
        ForecastCriteriaLocation::create(['id' => $itemCriteria->id, 'location_id' => $america]);
        ForecastCriteriaParameter::create(['value' => 0.2, 'monthly_growth' => 0,'criteria_id' => $device_finance_cost,'forecast_criteria_id' => $itemCriteria->id,  'date_from' => '2017-01-01', 'date_to' => '2020-12-01']);
    }

    public function revenue_device_financing($global, $emerging, $europe, $america, $india) {
        $id = 24;

        $ktm_fee = 51;
        $contract_period = 52;
        $monthly_churn_rate = 53;

        $Item = ForecastItem::create(['model_id' => 1, 'model_vid' => 1, 'date_from' => '2017-01-01', 'date_to' => '2020-12-1','coverage' => 1, 'monthly_growth' => 0]);

        ForecastItemItem::create(['id' => $Item->id, 'item_id' => $id]);
        ForecastItemLocation::create(['id' => $Item->id, 'location_id' => $global]); // Global
        ForecastItemLocation::create(['id' => $Item->id, 'location_id' => $emerging]); // Emerging Markets
        ForecastItemLocation::create(['id' => $Item->id, 'location_id' => $europe]); // Europe/Russia
        ForecastItemLocation::create(['id' => $Item->id, 'location_id' => $america]); // North America
        ForecastItemLocation::create(['id' => $Item->id, 'location_id' => $india]); // India

        $itemCriteria = ForecastCriteria::create(['model_id' => 1, 'model_vid' => 1,'item_id' => $id]);
        ForecastCriteriaLocation::create(['id' => $itemCriteria->id, 'location_id' => $emerging]);
        ForecastCriteriaLocation::create(['id' => $itemCriteria->id, 'location_id' => $europe]);
        ForecastCriteriaLocation::create(['id' => $itemCriteria->id, 'location_id' => $india]);
        ForecastCriteriaLocation::create(['id' => $itemCriteria->id, 'location_id' => $global]);
        ForecastCriteriaLocation::create(['id' => $itemCriteria->id, 'location_id' => $america]);
        ForecastCriteriaParameter::create(['value' => 0.2, 'monthly_growth' => 0,'criteria_id' => $ktm_fee,'forecast_criteria_id' => $itemCriteria->id,  'date_from' => '2017-01-01', 'date_to' => '2020-12-01']);
        ForecastCriteriaParameter::create(['value' => 0.2, 'monthly_growth' => 0,'criteria_id' => $contract_period,'forecast_criteria_id' => $itemCriteria->id,  'date_from' => '2017-01-01', 'date_to' => '2020-12-01']);
        ForecastCriteriaParameter::create(['value' => 0.2, 'monthly_growth' => 0,'criteria_id' => $monthly_churn_rate,'forecast_criteria_id' => $itemCriteria->id,  'date_from' => '2017-01-01', 'date_to' => '2020-12-01']);
    }

    public function yearly_app_preload($global, $emerging, $europe, $america, $india) {
        $id = 23;

        $yealy_placement_fee = 50;

        $Item = ForecastItem::create(['model_id' => 1, 'model_vid' => 1, 'date_from' => '2017-01-01', 'date_to' => '2020-12-1','coverage' => 1, 'monthly_growth' => 0]);

        ForecastItemItem::create(['id' => $Item->id, 'item_id' => $id]);
        ForecastItemLocation::create(['id' => $Item->id, 'location_id' => $global]); // Global
        ForecastItemLocation::create(['id' => $Item->id, 'location_id' => $emerging]); // Emerging Markets
        ForecastItemLocation::create(['id' => $Item->id, 'location_id' => $europe]); // Europe/Russia
        ForecastItemLocation::create(['id' => $Item->id, 'location_id' => $america]); // North America
        ForecastItemLocation::create(['id' => $Item->id, 'location_id' => $india]); // India

        $itemCriteria = ForecastCriteria::create(['model_id' => 1, 'model_vid' => 1,'item_id' => $id]);
        ForecastCriteriaLocation::create(['id' => $itemCriteria->id, 'location_id' => $emerging]);
        ForecastCriteriaLocation::create(['id' => $itemCriteria->id, 'location_id' => $europe]);
        ForecastCriteriaLocation::create(['id' => $itemCriteria->id, 'location_id' => $india]);
        ForecastCriteriaLocation::create(['id' => $itemCriteria->id, 'location_id' => $global]);
        ForecastCriteriaLocation::create(['id' => $itemCriteria->id, 'location_id' => $america]);
        ForecastCriteriaParameter::create(['value' => 0.2, 'monthly_growth' => 0,'criteria_id' => $yealy_placement_fee,'forecast_criteria_id' => $itemCriteria->id,  'date_from' => '2017-01-01', 'date_to' => '2020-12-01']);
    }

    public function carrier_tab_fee($global, $emerging, $europe, $america, $india) {
        $id = 22;

        $carrier_tab_fee_carrier = 48;
        $carrier_tab_Fee_open_market = 49;

        $Item = ForecastItem::create(['model_id' => 1, 'model_vid' => 1, 'date_from' => '2017-01-01', 'date_to' => '2020-12-1','coverage' => 1, 'monthly_growth' => 0]);

        ForecastItemItem::create(['id' => $Item->id, 'item_id' => $id]);
        ForecastItemLocation::create(['id' => $Item->id, 'location_id' => $global]); // Global
        ForecastItemLocation::create(['id' => $Item->id, 'location_id' => $emerging]); // Emerging Markets
        ForecastItemLocation::create(['id' => $Item->id, 'location_id' => $europe]); // Europe/Russia
        ForecastItemLocation::create(['id' => $Item->id, 'location_id' => $america]); // North America
        ForecastItemLocation::create(['id' => $Item->id, 'location_id' => $india]); // India

        $itemCriteria = ForecastCriteria::create(['model_id' => 1, 'model_vid' => 1,'item_id' => $id]);
        ForecastCriteriaLocation::create(['id' => $itemCriteria->id, 'location_id' => $emerging]);
        ForecastCriteriaLocation::create(['id' => $itemCriteria->id, 'location_id' => $europe]);
        ForecastCriteriaLocation::create(['id' => $itemCriteria->id, 'location_id' => $india]);
        ForecastCriteriaLocation::create(['id' => $itemCriteria->id, 'location_id' => $global]);
        ForecastCriteriaLocation::create(['id' => $itemCriteria->id, 'location_id' => $america]);
        ForecastCriteriaParameter::create(['value' => 0.2, 'monthly_growth' => 0,'criteria_id' => $carrier_tab_fee_carrier,'forecast_criteria_id' => $itemCriteria->id,  'date_from' => '2017-01-01', 'date_to' => '2020-12-01']);
        ForecastCriteriaParameter::create(['value' => 0.2, 'monthly_growth' => 0,'criteria_id' => $carrier_tab_Fee_open_market,'forecast_criteria_id' => $itemCriteria->id,  'date_from' => '2017-01-01', 'date_to' => '2020-12-01']);
    }

    public function app_preload($global, $emerging, $europe, $america, $india) {
        $id = 21;

        $placement_fee_carrier = 44;
        $preload_app_activation_rate_carrier = 45;
        $placement_fee_open_market = 46;
        $preload_app_activation_open_market = 47;

        $Item = ForecastItem::create(['model_id' => 1, 'model_vid' => 1, 'date_from' => '2017-01-01', 'date_to' => '2020-12-1','coverage' => 1, 'monthly_growth' => 0]);

        ForecastItemItem::create(['id' => $Item->id, 'item_id' => $id]);
        ForecastItemLocation::create(['id' => $Item->id, 'location_id' => $global]); // Global
        ForecastItemLocation::create(['id' => $Item->id, 'location_id' => $emerging]); // Emerging Markets
        ForecastItemLocation::create(['id' => $Item->id, 'location_id' => $europe]); // Europe/Russia
        ForecastItemLocation::create(['id' => $Item->id, 'location_id' => $america]); // North America
        ForecastItemLocation::create(['id' => $Item->id, 'location_id' => $india]); // India

        $itemCriteria = ForecastCriteria::create(['model_id' => 1, 'model_vid' => 1,'item_id' => $id]);
        ForecastCriteriaLocation::create(['id' => $itemCriteria->id, 'location_id' => $emerging]);
        ForecastCriteriaLocation::create(['id' => $itemCriteria->id, 'location_id' => $europe]);
        ForecastCriteriaLocation::create(['id' => $itemCriteria->id, 'location_id' => $india]);
        ForecastCriteriaLocation::create(['id' => $itemCriteria->id, 'location_id' => $global]);
        ForecastCriteriaLocation::create(['id' => $itemCriteria->id, 'location_id' => $america]);
        ForecastCriteriaParameter::create(['value' => 0.2, 'monthly_growth' => 0,'criteria_id' => $placement_fee_carrier,'forecast_criteria_id' => $itemCriteria->id,  'date_from' => '2017-01-01', 'date_to' => '2020-12-01']);
        ForecastCriteriaParameter::create(['value' => 0.2, 'monthly_growth' => 0,'criteria_id' => $preload_app_activation_rate_carrier,'forecast_criteria_id' => $itemCriteria->id,  'date_from' => '2017-01-01', 'date_to' => '2020-12-01']);
        ForecastCriteriaParameter::create(['value' => 0.2, 'monthly_growth' => 0,'criteria_id' => $placement_fee_open_market,'forecast_criteria_id' => $itemCriteria->id,  'date_from' => '2017-01-01', 'date_to' => '2020-12-01']);
        ForecastCriteriaParameter::create(['value' => 0.2, 'monthly_growth' => 0,'criteria_id' => $preload_app_activation_open_market,'forecast_criteria_id' => $itemCriteria->id,  'date_from' => '2017-01-01', 'date_to' => '2020-12-01']);
    }

    public function nre($global, $emerging, $europe, $america, $india) {
        $id = 20;

        $monthly_team_price = 43;

        $Item = ForecastItem::create(['model_id' => 1, 'model_vid' => 1, 'date_from' => '2017-01-01', 'date_to' => '2020-12-1','coverage' => 1, 'monthly_growth' => 0]);

        ForecastItemItem::create(['id' => $Item->id, 'item_id' => $id]);
        ForecastItemLocation::create(['id' => $Item->id, 'location_id' => $global]); // Global
        ForecastItemLocation::create(['id' => $Item->id, 'location_id' => $emerging]); // Emerging Markets
        ForecastItemLocation::create(['id' => $Item->id, 'location_id' => $europe]); // Europe/Russia
        ForecastItemLocation::create(['id' => $Item->id, 'location_id' => $america]); // North America
        ForecastItemLocation::create(['id' => $Item->id, 'location_id' => $india]); // India

        $itemCriteria = ForecastCriteria::create(['model_id' => 1, 'model_vid' => 1,'item_id' => $id]);
        ForecastCriteriaLocation::create(['id' => $itemCriteria->id, 'location_id' => $emerging]);
        ForecastCriteriaLocation::create(['id' => $itemCriteria->id, 'location_id' => $europe]);
        ForecastCriteriaLocation::create(['id' => $itemCriteria->id, 'location_id' => $india]);
        ForecastCriteriaLocation::create(['id' => $itemCriteria->id, 'location_id' => $global]);
        ForecastCriteriaLocation::create(['id' => $itemCriteria->id, 'location_id' => $america]);
        ForecastCriteriaParameter::create(['value' => 0.2, 'monthly_growth' => 0,'criteria_id' => $monthly_team_price,'forecast_criteria_id' => $itemCriteria->id,  'date_from' => '2017-01-01', 'date_to' => '2020-12-01']);
    }

    public function maintenance($global, $emerging, $europe, $america, $india) {
        $id = 19;

        $yearly_maintenance_price = 42;

        $Item = ForecastItem::create(['model_id' => 1, 'model_vid' => 1, 'date_from' => '2017-01-01', 'date_to' => '2020-12-1','coverage' => 1, 'monthly_growth' => 0]);

        ForecastItemItem::create(['id' => $Item->id, 'item_id' => $id]);
        ForecastItemLocation::create(['id' => $Item->id, 'location_id' => $global]); // Global
        ForecastItemLocation::create(['id' => $Item->id, 'location_id' => $emerging]); // Emerging Markets
        ForecastItemLocation::create(['id' => $Item->id, 'location_id' => $europe]); // Europe/Russia
        ForecastItemLocation::create(['id' => $Item->id, 'location_id' => $america]); // North America
        ForecastItemLocation::create(['id' => $Item->id, 'location_id' => $india]); // India

        $itemCriteria = ForecastCriteria::create(['model_id' => 1, 'model_vid' => 1,'item_id' => $id]);
        ForecastCriteriaLocation::create(['id' => $itemCriteria->id, 'location_id' => $emerging]);
        ForecastCriteriaLocation::create(['id' => $itemCriteria->id, 'location_id' => $europe]);
        ForecastCriteriaLocation::create(['id' => $itemCriteria->id, 'location_id' => $india]);
        ForecastCriteriaLocation::create(['id' => $itemCriteria->id, 'location_id' => $global]);
        ForecastCriteriaLocation::create(['id' => $itemCriteria->id, 'location_id' => $america]);
        ForecastCriteriaParameter::create(['value' => 0.2, 'monthly_growth' => 0,'criteria_id' => $yearly_maintenance_price,'forecast_criteria_id' => $itemCriteria->id,  'date_from' => '2017-01-01', 'date_to' => '2020-12-01']);
    }

    public function cost_3rd_party_licenses($global, $emerging, $europe, $america, $india) {
        $id = 18;

        $touchpal_licenses_fee = 41;

        $Item = ForecastItem::create(['model_id' => 1, 'model_vid' => 1, 'date_from' => '2017-01-01', 'date_to' => '2020-12-1','coverage' => 1, 'monthly_growth' => 0]);

        ForecastItemItem::create(['id' => $Item->id, 'item_id' => $id]);
        ForecastItemLocation::create(['id' => $Item->id, 'location_id' => $global]); // Global
        ForecastItemLocation::create(['id' => $Item->id, 'location_id' => $emerging]); // Emerging Markets
        ForecastItemLocation::create(['id' => $Item->id, 'location_id' => $europe]); // Europe/Russia
        ForecastItemLocation::create(['id' => $Item->id, 'location_id' => $america]); // North America
        ForecastItemLocation::create(['id' => $Item->id, 'location_id' => $india]); // India

        $itemCriteria = ForecastCriteria::create(['model_id' => 1, 'model_vid' => 1,'item_id' => $id]);
        ForecastCriteriaLocation::create(['id' => $itemCriteria->id, 'location_id' => $emerging]);
        ForecastCriteriaLocation::create(['id' => $itemCriteria->id, 'location_id' => $europe]);
        ForecastCriteriaLocation::create(['id' => $itemCriteria->id, 'location_id' => $india]);
        ForecastCriteriaLocation::create(['id' => $itemCriteria->id, 'location_id' => $global]);
        ForecastCriteriaLocation::create(['id' => $itemCriteria->id, 'location_id' => $america]);
        ForecastCriteriaParameter::create(['value' => 0.2, 'monthly_growth' => 0,'criteria_id' => $touchpal_licenses_fee,'forecast_criteria_id' => $itemCriteria->id,  'date_from' => '2017-01-01', 'date_to' => '2020-12-01']);


    }

    public function revenue_3rd_party_licenses($global, $emerging, $europe, $america, $india) {
        $id = 16;

        $touchpal_licenses_fee = 40;



        $Item = ForecastItem::create(['model_id' => 1, 'model_vid' => 1, 'date_from' => '2017-01-01', 'date_to' => '2020-12-1','coverage' => 1, 'monthly_growth' => 0]);

        ForecastItemItem::create(['id' => $Item->id, 'item_id' => $id]);
        ForecastItemLocation::create(['id' => $Item->id, 'location_id' => $global]); // Global
        ForecastItemLocation::create(['id' => $Item->id, 'location_id' => $emerging]); // Emerging Markets
        ForecastItemLocation::create(['id' => $Item->id, 'location_id' => $europe]); // Europe/Russia
        ForecastItemLocation::create(['id' => $Item->id, 'location_id' => $america]); // North America
        ForecastItemLocation::create(['id' => $Item->id, 'location_id' => $india]); // India

        $itemCriteria = ForecastCriteria::create(['model_id' => 1, 'model_vid' => 1,'item_id' => $id]);
        ForecastCriteriaLocation::create(['id' => $itemCriteria->id, 'location_id' => $emerging]);
        ForecastCriteriaLocation::create(['id' => $itemCriteria->id, 'location_id' => $europe]);
        ForecastCriteriaLocation::create(['id' => $itemCriteria->id, 'location_id' => $india]);
        ForecastCriteriaLocation::create(['id' => $itemCriteria->id, 'location_id' => $global]);
        ForecastCriteriaLocation::create(['id' => $itemCriteria->id, 'location_id' => $america]);
        ForecastCriteriaParameter::create(['value' => 0.2, 'monthly_growth' => 0,'criteria_id' => $touchpal_licenses_fee,'forecast_criteria_id' => $itemCriteria->id,  'date_from' => '2017-01-01', 'date_to' => '2020-12-01']);


    }

    public function payment_revenue_sharing($global, $emerging, $europe, $america, $india) {
        $id = 15;

        $oem_rev_share = 33;
        $carrier_rev_share = 34;
        $aggerg_rev_share = 35;
        $aggregator_app_ratio = 36;
        $app_dev_content_provider_rev_share = 37;
        $kai_apps_payment_revenue = 38;
        $billing_cut = 39;


        $Item = ForecastItem::create(['model_id' => 1, 'model_vid' => 1, 'date_from' => '2017-01-01', 'date_to' => '2020-12-1','coverage' => 1, 'monthly_growth' => 0]);

        ForecastItemItem::create(['id' => $Item->id, 'item_id' => $id]);
        ForecastItemLocation::create(['id' => $Item->id, 'location_id' => $global]); // Global
        ForecastItemLocation::create(['id' => $Item->id, 'location_id' => $emerging]); // Emerging Markets
        ForecastItemLocation::create(['id' => $Item->id, 'location_id' => $europe]); // Europe/Russia
        ForecastItemLocation::create(['id' => $Item->id, 'location_id' => $america]); // North America
        ForecastItemLocation::create(['id' => $Item->id, 'location_id' => $india]); // India

        $itemCriteria = ForecastCriteria::create(['model_id' => 1, 'model_vid' => 1,'item_id' => $id]);
        ForecastCriteriaLocation::create(['id' => $itemCriteria->id, 'location_id' => $emerging]);
        ForecastCriteriaLocation::create(['id' => $itemCriteria->id, 'location_id' => $europe]);
        ForecastCriteriaLocation::create(['id' => $itemCriteria->id, 'location_id' => $india]);
        ForecastCriteriaLocation::create(['id' => $itemCriteria->id, 'location_id' => $global]);
        ForecastCriteriaLocation::create(['id' => $itemCriteria->id, 'location_id' => $america]);
        ForecastCriteriaParameter::create(['value' => 0.2, 'monthly_growth' => 0,'criteria_id' => $oem_rev_share,'forecast_criteria_id' => $itemCriteria->id,  'date_from' => '2017-01-01', 'date_to' => '2020-12-01']);
        ForecastCriteriaParameter::create(['value' => 0.2, 'monthly_growth' => 0,'criteria_id' => $carrier_rev_share,'forecast_criteria_id' => $itemCriteria->id,  'date_from' => '2017-01-01', 'date_to' => '2020-12-01']);
        ForecastCriteriaParameter::create(['value' => 0.2, 'monthly_growth' => 0,'criteria_id' => $aggerg_rev_share,'forecast_criteria_id' => $itemCriteria->id,  'date_from' => '2017-01-01', 'date_to' => '2020-12-01']);
        ForecastCriteriaParameter::create(['value' => 0.2, 'monthly_growth' => 0,'criteria_id' => $aggregator_app_ratio,'forecast_criteria_id' => $itemCriteria->id,  'date_from' => '2017-01-01', 'date_to' => '2020-12-01']);
        ForecastCriteriaParameter::create(['value' => 0.2, 'monthly_growth' => 0,'criteria_id' => $app_dev_content_provider_rev_share,'forecast_criteria_id' => $itemCriteria->id,  'date_from' => '2017-01-01', 'date_to' => '2020-12-01']);
        ForecastCriteriaParameter::create(['value' => 0.2, 'monthly_growth' => 0,'criteria_id' => $kai_apps_payment_revenue,'forecast_criteria_id' => $itemCriteria->id,  'date_from' => '2017-01-01', 'date_to' => '2020-12-01']);
        ForecastCriteriaParameter::create(['value' => 0.2, 'monthly_growth' => 0,'criteria_id' => $billing_cut,'forecast_criteria_id' => $itemCriteria->id,  'date_from' => '2017-01-01', 'date_to' => '2020-12-01']);

    }

    public function payment_revenue_sharing_iap_v2($global, $emerging, $europe, $america, $india) {
        $id = 14;

        $apps_with_iap_ratio = 30;
        $conversion_to_purchase_iap = 31;
        $average_selling_price = 32;


        $Item = ForecastItem::create(['model_id' => 1, 'model_vid' => 1, 'date_from' => '2017-01-01', 'date_to' => '2020-12-1','coverage' => 1, 'monthly_growth' => 0]);

        ForecastItemItem::create(['id' => $Item->id, 'item_id' => $id]);
        ForecastItemLocation::create(['id' => $Item->id, 'location_id' => $global]); // Global
        ForecastItemLocation::create(['id' => $Item->id, 'location_id' => $emerging]); // Emerging Markets
        ForecastItemLocation::create(['id' => $Item->id, 'location_id' => $europe]); // Europe/Russia
        ForecastItemLocation::create(['id' => $Item->id, 'location_id' => $america]); // North America
        ForecastItemLocation::create(['id' => $Item->id, 'location_id' => $india]); // India

        $itemCriteria = ForecastCriteria::create(['model_id' => 1, 'model_vid' => 1,'item_id' => $id]);
        ForecastCriteriaLocation::create(['id' => $itemCriteria->id, 'location_id' => $emerging]);
        ForecastCriteriaLocation::create(['id' => $itemCriteria->id, 'location_id' => $europe]);
        ForecastCriteriaLocation::create(['id' => $itemCriteria->id, 'location_id' => $india]);
        ForecastCriteriaLocation::create(['id' => $itemCriteria->id, 'location_id' => $global]);
        ForecastCriteriaLocation::create(['id' => $itemCriteria->id, 'location_id' => $america]);
        ForecastCriteriaParameter::create(['value' => 0.2, 'monthly_growth' => 0,'criteria_id' => $apps_with_iap_ratio,'forecast_criteria_id' => $itemCriteria->id,  'date_from' => '2017-01-01', 'date_to' => '2020-12-01']);
        ForecastCriteriaParameter::create(['value' => 0.2, 'monthly_growth' => 0,'criteria_id' => $conversion_to_purchase_iap,'forecast_criteria_id' => $itemCriteria->id,  'date_from' => '2017-01-01', 'date_to' => '2020-12-01']);
        ForecastCriteriaParameter::create(['value' => 0.2, 'monthly_growth' => 0,'criteria_id' => $average_selling_price,'forecast_criteria_id' => $itemCriteria->id,  'date_from' => '2017-01-01', 'date_to' => '2020-12-01']);

    }

    public function payment_revenue_sharing_v2($global, $emerging, $europe, $america, $india) {
        $id = 13;

        $asp = 25;
        $mau_to_store_app_view_ratio = 26;
        $kaipay_coverage = 27;
        $store_app_view_of_paid_app = 28;
        $conversion_to_purchase_store = 29;


        $Item = ForecastItem::create(['model_id' => 1, 'model_vid' => 1, 'date_from' => '2017-01-01', 'date_to' => '2020-12-1','coverage' => 1, 'monthly_growth' => 0]);

        ForecastItemItem::create(['id' => $Item->id, 'item_id' => $id]);
        ForecastItemLocation::create(['id' => $Item->id, 'location_id' => $global]); // Global
        ForecastItemLocation::create(['id' => $Item->id, 'location_id' => $emerging]); // Emerging Markets
        ForecastItemLocation::create(['id' => $Item->id, 'location_id' => $europe]); // Europe/Russia
        ForecastItemLocation::create(['id' => $Item->id, 'location_id' => $america]); // North America
        ForecastItemLocation::create(['id' => $Item->id, 'location_id' => $india]); // India

        $itemCriteria = ForecastCriteria::create(['model_id' => 1, 'model_vid' => 1,'item_id' => $id]);
        ForecastCriteriaLocation::create(['id' => $itemCriteria->id, 'location_id' => $emerging]);
        ForecastCriteriaLocation::create(['id' => $itemCriteria->id, 'location_id' => $europe]);
        ForecastCriteriaLocation::create(['id' => $itemCriteria->id, 'location_id' => $india]);
        ForecastCriteriaLocation::create(['id' => $itemCriteria->id, 'location_id' => $global]);
        ForecastCriteriaLocation::create(['id' => $itemCriteria->id, 'location_id' => $america]);
        ForecastCriteriaParameter::create(['value' => 0.2, 'monthly_growth' => 0,'criteria_id' => $asp,'forecast_criteria_id' => $itemCriteria->id,  'date_from' => '2017-01-01', 'date_to' => '2020-12-01']);
        ForecastCriteriaParameter::create(['value' => 0.2, 'monthly_growth' => 0,'criteria_id' => $mau_to_store_app_view_ratio,'forecast_criteria_id' => $itemCriteria->id,  'date_from' => '2017-01-01', 'date_to' => '2020-12-01']);
        ForecastCriteriaParameter::create(['value' => 0.2, 'monthly_growth' => 0,'criteria_id' => $kaipay_coverage,'forecast_criteria_id' => $itemCriteria->id,  'date_from' => '2017-01-01', 'date_to' => '2020-12-01']);
        ForecastCriteriaParameter::create(['value' => 0.2, 'monthly_growth' => 0,'criteria_id' => $store_app_view_of_paid_app,'forecast_criteria_id' => $itemCriteria->id,  'date_from' => '2017-01-01', 'date_to' => '2020-12-01']);
        ForecastCriteriaParameter::create(['value' => 0.2, 'monthly_growth' => 0,'criteria_id' => $conversion_to_purchase_store,'forecast_criteria_id' => $itemCriteria->id,  'date_from' => '2017-01-01', 'date_to' => '2020-12-01']);

    }

    public function fota_royalty($global, $emerging, $europe, $america, $india) {
        $id = 9;

        $fee = 9;

        $Item = ForecastItem::create(['model_id' => 1, 'model_vid' => 1, 'date_from' => '2017-01-01', 'date_to' => '2020-12-1','coverage' => 1, 'monthly_growth' => 0]);

        ForecastItemItem::create(['id' => $Item->id, 'item_id' => $id]);
        ForecastItemLocation::create(['id' => $Item->id, 'location_id' => $global]); // Global
        ForecastItemLocation::create(['id' => $Item->id, 'location_id' => $emerging]); // Emerging Markets
        ForecastItemLocation::create(['id' => $Item->id, 'location_id' => $europe]); // Europe/Russia
        ForecastItemLocation::create(['id' => $Item->id, 'location_id' => $america]); // North America
        ForecastItemLocation::create(['id' => $Item->id, 'location_id' => $india]); // India

        $itemCriteria = ForecastCriteria::create(['model_id' => 1, 'model_vid' => 1,'item_id' => $id]);
        ForecastCriteriaLocation::create(['id' => $itemCriteria->id, 'location_id' => $emerging]);
        ForecastCriteriaLocation::create(['id' => $itemCriteria->id, 'location_id' => $europe]);
        ForecastCriteriaLocation::create(['id' => $itemCriteria->id, 'location_id' => $india]);
        ForecastCriteriaLocation::create(['id' => $itemCriteria->id, 'location_id' => $global]);
        ForecastCriteriaLocation::create(['id' => $itemCriteria->id, 'location_id' => $america]);
        ForecastCriteriaParameter::create(['value' => 0.2, 'monthly_growth' => 0,'forecast_criteria_id' => $itemCriteria->id, 'criteria_id' => $fee, 'date_from' => '2017-01-01', 'date_to' => '2020-12-01']);
    }

    public function fota_fee($global, $emerging, $europe, $america, $india) {
        $id = 8;

        $fota_fee = 8;

        $Item = ForecastItem::create(['model_id' => 1, 'model_vid' => 1, 'date_from' => '2017-01-01', 'date_to' => '2020-12-1','coverage' => 1, 'monthly_growth' => 0]);

        ForecastItemItem::create(['id' => $Item->id, 'item_id' => $id]);
        ForecastItemLocation::create(['id' => $Item->id, 'location_id' => $global]); // Global
        ForecastItemLocation::create(['id' => $Item->id, 'location_id' => $emerging]); // Emerging Markets
        ForecastItemLocation::create(['id' => $Item->id, 'location_id' => $europe]); // Europe/Russia
        ForecastItemLocation::create(['id' => $Item->id, 'location_id' => $america]); // North America
        ForecastItemLocation::create(['id' => $Item->id, 'location_id' => $india]); // India

        $itemCriteria = ForecastCriteria::create(['model_id' => 1, 'model_vid' => 1,'item_id' => $id]);
        ForecastCriteriaLocation::create(['id' => $itemCriteria->id, 'location_id' => $emerging]);
        ForecastCriteriaLocation::create(['id' => $itemCriteria->id, 'location_id' => $europe]);
        ForecastCriteriaLocation::create(['id' => $itemCriteria->id, 'location_id' => $india]);
        ForecastCriteriaLocation::create(['id' => $itemCriteria->id, 'location_id' => $global]);
        ForecastCriteriaLocation::create(['id' => $itemCriteria->id, 'location_id' => $america]);
        ForecastCriteriaParameter::create(['value' => 0.2, 'monthly_growth' => 0,'forecast_criteria_id' => $itemCriteria->id, 'criteria_id' => $fota_fee, 'date_from' => '2017-01-01', 'date_to' => '2020-12-01']);
    }

    public function ads_revenue_sharing($global, $emerging, $europe, $america, $india) {
        $id = 11;

        $monthly_page_view = 11;
        $ecpm = 12;
        $ads_revenue_per_1k_ads_dau = 13;

        $Item = ForecastItem::create(['model_id' => 1, 'model_vid' => 1, 'date_from' => '2017-01-01', 'date_to' => '2020-12-1' , 'coverage' => 1, 'monthly_growth' => 0]);

        ForecastItemItem::create(['id' => $Item->id, 'item_id' => $id]);
        ForecastItemLocation::create(['id' => $Item->id, 'location_id' => $global]); // Global
        ForecastItemLocation::create(['id' => $Item->id, 'location_id' => $emerging]); // Emerging Markets
        ForecastItemLocation::create(['id' => $Item->id, 'location_id' => $europe]); // Europe/Russia
        ForecastItemLocation::create(['id' => $Item->id, 'location_id' => $america]); // North America
        ForecastItemLocation::create(['id' => $Item->id, 'location_id' => $india]); // India

        $itemCriteria = ForecastCriteria::create(['model_id' => 1, 'model_vid' => 1,'item_id' => $id]);
        ForecastCriteriaLocation::create(['id' => $itemCriteria->id, 'location_id' => $emerging]);
        ForecastCriteriaParameter::create(['value' => 0, 'monthly_growth' => 0,'forecast_criteria_id' => $itemCriteria->id, 'criteria_id' => $monthly_page_view, 'date_from' => '2017-01-01', 'date_to' => '2020-12-01']);
        ForecastCriteriaParameter::create(['value' => 0, 'monthly_growth' => 0,'forecast_criteria_id' => $itemCriteria->id, 'criteria_id' => $ecpm, 'date_from' => '2017-01-01', 'date_to' => '2020-12-01']);
        ForecastCriteriaParameter::create(['value' => 2.64, 'monthly_growth' => 0.17,'forecast_criteria_id' => $itemCriteria->id, 'criteria_id' => $ads_revenue_per_1k_ads_dau, 'date_from' => '2017-01-01', 'date_to' => '2020-12-01']);

        $itemCriteria = ForecastCriteria::create(['model_id' => 1, 'model_vid' => 1,'item_id' => $id]);
        ForecastCriteriaLocation::create(['id' => $itemCriteria->id, 'location_id' => $europe]);
        ForecastCriteriaParameter::create(['value' => 0, 'monthly_growth' => 0,'forecast_criteria_id' => $itemCriteria->id, 'criteria_id' => $monthly_page_view, 'date_from' => '2017-01-01', 'date_to' => '2020-12-01']);
        ForecastCriteriaParameter::create(['value' => 0, 'monthly_growth' => 0,'forecast_criteria_id' => $itemCriteria->id, 'criteria_id' => $ecpm, 'date_from' => '2017-01-01', 'date_to' => '2020-12-01']);
        ForecastCriteriaParameter::create(['value' => 4.70, 'monthly_growth' => 0.18,'forecast_criteria_id' => $itemCriteria->id, 'criteria_id' => $ads_revenue_per_1k_ads_dau, 'date_from' => '2017-01-01', 'date_to' => '2020-12-01']);

        $itemCriteria = ForecastCriteria::create(['model_id' => 1, 'model_vid' => 1,'item_id' => $id]);
        ForecastCriteriaLocation::create(['id' => $itemCriteria->id, 'location_id' => $india]);
        ForecastCriteriaParameter::create(['value' => 0.1, 'monthly_growth' => 0.9,'forecast_criteria_id' => $itemCriteria->id, 'criteria_id' => $monthly_page_view, 'date_from' => '2017-01-01', 'date_to' => '2020-12-01']);
        ForecastCriteriaParameter::create(['value' => 0.15, 'monthly_growth' => 0.05,'forecast_criteria_id' => $itemCriteria->id, 'criteria_id' => $ecpm, 'date_from' => '2017-01-01', 'date_to' => '2020-12-01']);
        ForecastCriteriaParameter::create(['value' => 0, 'monthly_growth' => 0,'forecast_criteria_id' => $itemCriteria->id, 'criteria_id' => $ads_revenue_per_1k_ads_dau, 'date_from' => '2017-01-01', 'date_to' => '2020-12-01']);

        $itemCriteria = ForecastCriteria::create(['model_id' => 1, 'model_vid' => 1,'item_id' => $id]);
        ForecastCriteriaLocation::create(['id' => $itemCriteria->id, 'location_id' => $global]);
        ForecastCriteriaParameter::create(['value' => 0, 'monthly_growth' => 0,'forecast_criteria_id' => $itemCriteria->id, 'criteria_id' => $monthly_page_view, 'date_from' => '2017-01-01', 'date_to' => '2020-12-01']);
        ForecastCriteriaParameter::create(['value' => 0, 'monthly_growth' => 0,'forecast_criteria_id' => $itemCriteria->id, 'criteria_id' => $ecpm, 'date_from' => '2017-01-01', 'date_to' => '2020-12-01']);
        ForecastCriteriaParameter::create(['value' => 0, 'monthly_growth' => 0,'forecast_criteria_id' => $itemCriteria->id, 'criteria_id' => $ads_revenue_per_1k_ads_dau, 'date_from' => '2017-01-01', 'date_to' => '2020-12-01']);

        $itemCriteria = ForecastCriteria::create(['model_id' => 1, 'model_vid' => 1,'item_id' => $id]);
        ForecastCriteriaLocation::create(['id' => $itemCriteria->id, 'location_id' => $america]);
        ForecastCriteriaParameter::create(['value' => 0, 'monthly_growth' => 0,'forecast_criteria_id' => $itemCriteria->id, 'criteria_id' => $monthly_page_view, 'date_from' => '2017-01-01', 'date_to' => '2020-12-01']);
        ForecastCriteriaParameter::create(['value' => 0, 'monthly_growth' => 0,'forecast_criteria_id' => $itemCriteria->id, 'criteria_id' => $ecpm, 'date_from' => '2017-01-01', 'date_to' => '2020-12-01']);
        ForecastCriteriaParameter::create(['value' => 5.80, 'monthly_growth' => 0.18,'forecast_criteria_id' => $itemCriteria->id, 'criteria_id' => $ads_revenue_per_1k_ads_dau, 'date_from' => '2017-01-01', 'date_to' => '2020-12-01']);


    }

    public function search_revenue_sharing($global, $emerging, $europe, $america, $india) {
        $id = 10;

        $onekPerMAU = 10;

        $Item = ForecastItem::create(['model_id' => 1, 'model_vid' => 1, 'date_from' => '2017-01-01', 'date_to' => '2020-12-1' , 'coverage' => 1, 'monthly_growth' => 0]);

        ForecastItemItem::create(['id' => $Item->id, 'item_id' => $id]);
        ForecastItemLocation::create(['id' => $Item->id, 'location_id' => $global]); // Global
        ForecastItemLocation::create(['id' => $Item->id, 'location_id' => $emerging]); // Emerging Markets
        ForecastItemLocation::create(['id' => $Item->id, 'location_id' => $europe]); // Europe/Russia
        ForecastItemLocation::create(['id' => $Item->id, 'location_id' => $america]); // North America
        ForecastItemLocation::create(['id' => $Item->id, 'location_id' => $india]); // India

        $itemCriteria = ForecastCriteria::create(['model_id' => 1, 'model_vid' => 1,'item_id' => $id]);
        ForecastCriteriaLocation::create(['id' => $itemCriteria->id, 'location_id' => $emerging]);
        ForecastCriteriaParameter::create(['value' => 2.64, 'monthly_growth' => 0.17,'forecast_criteria_id' => $itemCriteria->id, 'criteria_id' => $onekPerMAU, 'date_from' => '2017-01-01', 'date_to' => '2020-12-01']);

        $itemCriteria = ForecastCriteria::create(['model_id' => 1, 'model_vid' => 1,'item_id' => $id]);
        ForecastCriteriaLocation::create(['id' => $itemCriteria->id, 'location_id' => $europe]);
        ForecastCriteriaParameter::create(['value' => 4.70, 'monthly_growth' => 0.18,'forecast_criteria_id' => $itemCriteria->id, 'criteria_id' => $onekPerMAU, 'date_from' => '2017-01-01', 'date_to' => '2020-12-01']);

        $itemCriteria = ForecastCriteria::create(['model_id' => 1, 'model_vid' => 1,'item_id' => $id]);
        ForecastCriteriaLocation::create(['id' => $itemCriteria->id, 'location_id' => $india]);
        ForecastCriteriaParameter::create(['value' => 0, 'monthly_growth' => 0,'forecast_criteria_id' => $itemCriteria->id, 'criteria_id' => $onekPerMAU, 'date_from' => '2017-01-01', 'date_to' => '2020-12-01']);

        $itemCriteria = ForecastCriteria::create(['model_id' => 1, 'model_vid' => 1,'item_id' => $id]);
        ForecastCriteriaLocation::create(['id' => $itemCriteria->id, 'location_id' => $global]);
        ForecastCriteriaParameter::create(['value' => 0, 'monthly_growth' => 0,'forecast_criteria_id' => $itemCriteria->id, 'criteria_id' => $onekPerMAU, 'date_from' => '2017-01-01', 'date_to' => '2020-12-01']);

        $itemCriteria = ForecastCriteria::create(['model_id' => 1, 'model_vid' => 1,'item_id' => $id]);
        ForecastCriteriaLocation::create(['id' => $itemCriteria->id, 'location_id' => $america]);
        ForecastCriteriaParameter::create(['value' => 6.11, 'monthly_growth' => 0.06,'forecast_criteria_id' => $itemCriteria->id, 'criteria_id' => $onekPerMAU, 'date_from' => '2017-01-01', 'date_to' => '2020-12-01']);
    }

    public function ads_mau($global, $emerging, $europe, $america, $india) {
        $id = 6;

        $mauToAdsDauRatio = 7;

        $Item = ForecastItem::create(['model_id' => 1, 'model_vid' => 1, 'date_from' => '2017-01-01', 'date_to' => '2020-12-1' , 'coverage' => 1, 'monthly_growth' => 0]);

        ForecastItemItem::create(['id' => $Item->id, 'item_id' => $id]);
        ForecastItemLocation::create(['id' => $Item->id, 'location_id' => $global]); // Global
        ForecastItemLocation::create(['id' => $Item->id, 'location_id' => $emerging]); // Emerging Markets
        ForecastItemLocation::create(['id' => $Item->id, 'location_id' => $europe]); // Europe/Russia
        ForecastItemLocation::create(['id' => $Item->id, 'location_id' => $america]); // North America
        ForecastItemLocation::create(['id' => $Item->id, 'location_id' => $india]); // India

        $itemCriteria = ForecastCriteria::create(['model_id' => 1, 'model_vid' => 1,'item_id' => $id]);
        ForecastCriteriaLocation::create(['id' => $itemCriteria->id, 'location_id' => $emerging]);
        ForecastCriteriaParameter::create(['value' => 0.0193646, 'monthly_growth' => 0.06,'forecast_criteria_id' => $itemCriteria->id, 'criteria_id' => $mauToAdsDauRatio, 'date_from' => '2017-01-01', 'date_to' => '2020-12-01']);

        $itemCriteria = ForecastCriteria::create(['model_id' => 1, 'model_vid' => 1,'item_id' => $id]);
        ForecastCriteriaLocation::create(['id' => $itemCriteria->id, 'location_id' => $europe]);
        ForecastCriteriaParameter::create(['value' => 0.0193646, 'monthly_growth' => 0.06,'forecast_criteria_id' => $itemCriteria->id, 'criteria_id' => $mauToAdsDauRatio, 'date_from' => '2017-01-01', 'date_to' => '2020-12-01']);

        $itemCriteria = ForecastCriteria::create(['model_id' => 1, 'model_vid' => 1,'item_id' => $id]);
        ForecastCriteriaLocation::create(['id' => $itemCriteria->id, 'location_id' => $india]);
        ForecastCriteriaParameter::create(['value' => 0.46, 'monthly_growth' => 0.06,'forecast_criteria_id' => $itemCriteria->id, 'criteria_id' => $mauToAdsDauRatio, 'date_from' => '2017-01-01', 'date_to' => '2020-12-01']);

        $itemCriteria = ForecastCriteria::create(['model_id' => 1, 'model_vid' => 1,'item_id' => $id]);
        ForecastCriteriaLocation::create(['id' => $itemCriteria->id, 'location_id' => $global]);
        ForecastCriteriaParameter::create(['value' => 0.0193646, 'monthly_growth' => 0.06,'forecast_criteria_id' => $itemCriteria->id, 'criteria_id' => $mauToAdsDauRatio, 'date_from' => '2017-01-01', 'date_to' => '2020-12-01']);

        $itemCriteria = ForecastCriteria::create(['model_id' => 1, 'model_vid' => 1,'item_id' => $id]);
        ForecastCriteriaLocation::create(['id' => $itemCriteria->id, 'location_id' => $america]);
        ForecastCriteriaParameter::create(['value' => 0.025, 'monthly_growth' => 0.06,'forecast_criteria_id' => $itemCriteria->id, 'criteria_id' => $mauToAdsDauRatio, 'date_from' => '2017-01-01', 'date_to' => '2020-12-01']);

    }

    public function mau($global, $emerging, $europe, $america, $india) {
        $id = 5;

        $initialMAURatio = 5;
        $mauGrowthFactor = 6;

        $Item = ForecastItem::create(['model_id' => 1, 'model_vid' => 1, 'date_from' => '2017-01-01', 'date_to' => '2020-12-1' , 'coverage' => 1, 'monthly_growth' => 0]);

        ForecastItemItem::create(['id' => $Item->id, 'item_id' => $id]);
        ForecastItemLocation::create(['id' => $Item->id, 'location_id' => $global]); // Global
        ForecastItemLocation::create(['id' => $Item->id, 'location_id' => $emerging]); // Emerging Markets
        ForecastItemLocation::create(['id' => $Item->id, 'location_id' => $europe]); // Europe/Russia
        ForecastItemLocation::create(['id' => $Item->id, 'location_id' => $america]); // North America
        ForecastItemLocation::create(['id' => $Item->id, 'location_id' => $india]); // India

        $itemCriteria = ForecastCriteria::create(['model_id' => 1, 'model_vid' => 1,'item_id' => $id]);
        ForecastCriteriaLocation::create(['id' => $itemCriteria->id, 'location_id' => $emerging]);
        ForecastCriteriaParameter::create(['value' => 0.465907381962302, 'monthly_growth' => 0,'forecast_criteria_id' => $itemCriteria->id, 'criteria_id' => $initialMAURatio, 'date_from' => '2017-01-01', 'date_to' => '2020-12-01']);
        ForecastCriteriaParameter::create(['value' => 0.46, 'monthly_growth' => 0,'forecast_criteria_id' => $itemCriteria->id, 'criteria_id' => $mauGrowthFactor, 'date_from' => '2017-01-01', 'date_to' => '2020-12-01']);

        $itemCriteria = ForecastCriteria::create(['model_id' => 1, 'model_vid' => 1,'item_id' => $id]);
        ForecastCriteriaLocation::create(['id' => $itemCriteria->id, 'location_id' => $europe]);
        ForecastCriteriaParameter::create(['value' => 0.405, 'monthly_growth' => 0,'forecast_criteria_id' => $itemCriteria->id, 'criteria_id' => $initialMAURatio, 'date_from' => '2017-01-01', 'date_to' => '2020-12-01']);
        ForecastCriteriaParameter::create(['value' => 0.40, 'monthly_growth' => 0,'forecast_criteria_id' => $itemCriteria->id, 'criteria_id' => $mauGrowthFactor, 'date_from' => '2017-01-01', 'date_to' => '2020-12-01']);

        $itemCriteria = ForecastCriteria::create(['model_id' => 1, 'model_vid' => 1,'item_id' => $id]);
        ForecastCriteriaLocation::create(['id' => $itemCriteria->id, 'location_id' => $india]);
        ForecastCriteriaParameter::create(['value' => 1, 'monthly_growth' => 0,'forecast_criteria_id' => $itemCriteria->id, 'criteria_id' => $initialMAURatio, 'date_from' => '2017-01-01', 'date_to' => '2020-12-01']);
        ForecastCriteriaParameter::create(['value' => 1, 'monthly_growth' => 0,'forecast_criteria_id' => $itemCriteria->id, 'criteria_id' => $mauGrowthFactor, 'date_from' => '2017-01-01', 'date_to' => '2020-12-01']);

        $itemCriteria = ForecastCriteria::create(['model_id' => 1, 'model_vid' => 1,'item_id' => $id]);
        ForecastCriteriaLocation::create(['id' => $itemCriteria->id, 'location_id' => $global]);
        ForecastCriteriaParameter::create(['value' => 0.465907381962302, 'monthly_growth' => 0,'forecast_criteria_id' => $itemCriteria->id, 'criteria_id' => $initialMAURatio, 'date_from' => '2017-01-01', 'date_to' => '2020-12-01']);
        ForecastCriteriaParameter::create(['value' => 0.67, 'monthly_growth' => 0,'forecast_criteria_id' => $itemCriteria->id, 'criteria_id' => $mauGrowthFactor, 'date_from' => '2017-01-01', 'date_to' => '2020-12-01']);

        $itemCriteria = ForecastCriteria::create(['model_id' => 1, 'model_vid' => 1,'item_id' => $id]);
        ForecastCriteriaLocation::create(['id' => $itemCriteria->id, 'location_id' => $america]);
        ForecastCriteriaParameter::create(['value' => 0.408, 'monthly_growth' => 0,'forecast_criteria_id' => $itemCriteria->id, 'criteria_id' => $initialMAURatio, 'date_from' => '2017-01-01', 'date_to' => '2020-12-01']);
        ForecastCriteriaParameter::create(['value' => 0.41, 'monthly_growth' => 0,'forecast_criteria_id' => $itemCriteria->id, 'criteria_id' => $mauGrowthFactor, 'date_from' => '2017-01-01', 'date_to' => '2020-12-01']);
    }

    public function active_device($global, $emerging, $europe, $america, $india) {
        $id = 4;

        $activationRation = 4;

        $Item = ForecastItem::create(['model_id' => 1, 'model_vid' => 1, 'date_from' => '2017-01-01', 'date_to' => '2020-12-1' , 'coverage' => 1, 'monthly_growth' => 0]);

        ForecastItemItem::create(['id' => $Item->id, 'item_id' => $id]);
        ForecastItemLocation::create(['id' => $Item->id, 'location_id' => $global]); // Global
        ForecastItemLocation::create(['id' => $Item->id, 'location_id' => $emerging]); // Emerging Markets
        ForecastItemLocation::create(['id' => $Item->id, 'location_id' => $europe]); // Europe/Russia
        ForecastItemLocation::create(['id' => $Item->id, 'location_id' => $america]); // North America
        ForecastItemLocation::create(['id' => $Item->id, 'location_id' => $india]); // India

        $itemCriteria = ForecastCriteria::create(['model_id' => 1, 'model_vid' => 1,'item_id' => $id]);
        ForecastCriteriaLocation::create(['id' => $itemCriteria->id, 'location_id' => $emerging]);
        ForecastCriteriaParameter::create(['value' => 0.561709826880253, 'monthly_growth' => 0.01,'forecast_criteria_id' => $itemCriteria->id, 'criteria_id' => $activationRation, 'date_from' => '2017-01-01', 'date_to' => '2020-12-01']);

        $itemCriteria = ForecastCriteria::create(['model_id' => 1, 'model_vid' => 1,'item_id' => $id]);
        ForecastCriteriaLocation::create(['id' => $itemCriteria->id, 'location_id' => $europe]);
        ForecastCriteriaParameter::create(['value' => 0.38796594886216, 'monthly_growth' => 0,'forecast_criteria_id' => $itemCriteria->id, 'criteria_id' => $activationRation, 'date_from' => '2017-01-01', 'date_to' => '2020-12-01']);

        $itemCriteria = ForecastCriteria::create(['model_id' => 1, 'model_vid' => 1,'item_id' => $id]);
        ForecastCriteriaLocation::create(['id' => $itemCriteria->id, 'location_id' => $india]);
        ForecastCriteriaParameter::create(['value' => 0.85, 'monthly_growth' => 0,'forecast_criteria_id' => $itemCriteria->id, 'criteria_id' => $activationRation, 'date_from' => '2017-01-01', 'date_to' => '2020-12-01']);

        $itemCriteria = ForecastCriteria::create(['model_id' => 1, 'model_vid' => 1,'item_id' => $id]);
        ForecastCriteriaLocation::create(['id' => $itemCriteria->id, 'location_id' => $global]);
        ForecastCriteriaParameter::create(['value' => 0.561709826880253, 'monthly_growth' => 0.01,'forecast_criteria_id' => $itemCriteria->id, 'criteria_id' => $activationRation, 'date_from' => '2017-01-01', 'date_to' => '2020-12-01']);

        $itemCriteria = ForecastCriteria::create(['model_id' => 1, 'model_vid' => 1,'item_id' => $id]);
        ForecastCriteriaLocation::create(['id' => $itemCriteria->id, 'location_id' => $america]);
        ForecastCriteriaParameter::create(['value' => 0.23, 'monthly_growth' => 0.012,'forecast_criteria_id' => $itemCriteria->id, 'criteria_id' => $activationRation, 'date_from' => '2017-01-01', 'date_to' => '2020-12-01']);
    }

    public function install_base($global, $emerging, $europe, $america, $india) {
        $installBaseItem = ForecastItem::create(['model_id' => 1, 'model_vid' => 1, 'date_from' => '2017-01-01', 'date_to' => '2020-12-1' , 'coverage' => 1, 'monthly_growth' => 0]);
        ForecastItemItem::create(['id' => $installBaseItem->id, 'item_id' => 3]);
        ForecastItemLocation::create(['id' => $installBaseItem->id, 'location_id' => $global]); // Global
        ForecastItemLocation::create(['id' => $installBaseItem->id, 'location_id' => $emerging]); // Emerging Markets
        ForecastItemLocation::create(['id' => $installBaseItem->id, 'location_id' => $europe]); // Europe/Russia
        ForecastItemLocation::create(['id' => $installBaseItem->id, 'location_id' => $america]); // North America
        ForecastItemLocation::create(['id' => $installBaseItem->id, 'location_id' => $india]); // India

        $installBaseCriteria = ForecastCriteria::create(['model_id' => 1, 'model_vid' => 1,'item_id' => 3]);
        ForecastCriteriaLocation::create(['id' => $installBaseCriteria->id, 'location_id' => $emerging]);
        ForecastCriteriaParameter::create(['value' => 0.024, 'monthly_growth' => 0,'forecast_criteria_id' => $installBaseCriteria->id, 'criteria_id' => 2, 'date_from' => '2017-01-01', 'date_to' => '2020-12-01']);
        ForecastCriteriaParameter::create(['value' => 30, 'monthly_growth' => 0,'forecast_criteria_id' => $installBaseCriteria->id, 'criteria_id' => 3, 'date_from' => '2017-01-01', 'date_to' => '2020-12-01']);

        $installBaseCriteria = ForecastCriteria::create(['model_id' => 1, 'model_vid' => 1,'item_id' => 3]);
        ForecastCriteriaLocation::create(['id' => $installBaseCriteria->id, 'location_id' => $europe]);
        ForecastCriteriaParameter::create(['value' => 0.03, 'monthly_growth' => 0,'forecast_criteria_id' => $installBaseCriteria->id, 'criteria_id' => 2, 'date_from' => '2017-01-01', 'date_to' => '2020-12-01']);
        ForecastCriteriaParameter::create(['value' => 24, 'monthly_growth' => 0,'forecast_criteria_id' => $installBaseCriteria->id, 'criteria_id' => 3, 'date_from' => '2017-01-01', 'date_to' => '2020-12-01']);

        $installBaseCriteria = ForecastCriteria::create(['model_id' => 1, 'model_vid' => 1,'item_id' => 3]);
        ForecastCriteriaLocation::create(['id' => $installBaseCriteria->id, 'location_id' => $india]);
        ForecastCriteriaParameter::create(['value' => 0.02, 'monthly_growth' => 0,'forecast_criteria_id' => $installBaseCriteria->id, 'criteria_id' => 2, 'date_from' => '2017-01-01', 'date_to' => '2020-12-01']);
        ForecastCriteriaParameter::create(['value' => 36, 'monthly_growth' => 0,'forecast_criteria_id' => $installBaseCriteria->id, 'criteria_id' => 3, 'date_from' => '2017-01-01', 'date_to' => '2020-12-01']);

        $installBaseCriteria = ForecastCriteria::create(['model_id' => 1, 'model_vid' => 1,'item_id' => 3]);
        ForecastCriteriaLocation::create(['id' => $installBaseCriteria->id, 'location_id' => $global]);
        ForecastCriteriaParameter::create(['value' => 0.03, 'monthly_growth' => 0,'forecast_criteria_id' => $installBaseCriteria->id, 'criteria_id' => 2, 'date_from' => '2017-01-01', 'date_to' => '2020-12-01']);
        ForecastCriteriaParameter::create(['value' => 24, 'monthly_growth' => 0,'forecast_criteria_id' => $installBaseCriteria->id, 'criteria_id' => 3, 'date_from' => '2017-01-01', 'date_to' => '2020-12-01']);

        $installBaseCriteria = ForecastCriteria::create(['model_id' => 1, 'model_vid' => 1,'item_id' => 3]);
        ForecastCriteriaLocation::create(['id' => $installBaseCriteria->id, 'location_id' => $america]);
        ForecastCriteriaParameter::create(['value' => 0.03, 'monthly_growth' => 0,'forecast_criteria_id' => $installBaseCriteria->id, 'criteria_id' => 2, 'date_from' => '2017-01-01', 'date_to' => '2020-12-01']);
        ForecastCriteriaParameter::create(['value' => 24, 'monthly_growth' => 0,'forecast_criteria_id' => $installBaseCriteria->id, 'criteria_id' => 3, 'date_from' => '2017-01-01', 'date_to' => '2020-12-01']);

    }

    public function shipment($global, $emerging, $europe, $america, $india) {
        $shipmentItem = ForecastItem::create(['model_id' => 1, 'model_vid' => 1, 'date_from' => '2017-01-01', 'date_to' => '2020-12-1' , 'coverage' => 1, 'monthly_growth' => 0]);

        ForecastItemItem::create(['id' => $shipmentItem->id, 'item_id' => 2]);

        ForecastItemLocation::create(['id' => $shipmentItem->id, 'location_id' => $global]); // Global
        ForecastItemLocation::create(['id' => $shipmentItem->id, 'location_id' => $emerging]); // Emerging Markets
        ForecastItemLocation::create(['id' => $shipmentItem->id, 'location_id' => $europe]); // Europe/Russia
        ForecastItemLocation::create(['id' => $shipmentItem->id, 'location_id' => $america]); // North America
        ForecastItemLocation::create(['id' => $shipmentItem->id, 'location_id' => $india]); // India

        $shipmentCriteria = ForecastCriteria::create(['model_id' => 1, 'model_vid' => 1,'item_id' => 2]);
        ForecastCriteriaLocation::create(['id' => $shipmentCriteria->id, 'location_id' => $global]); // Global
        ForecastCriteriaLocation::create(['id' => $shipmentCriteria->id, 'location_id' => $emerging]); // Emerging Markets
        ForecastCriteriaLocation::create(['id' => $shipmentCriteria->id, 'location_id' => $europe]); // Europe/Russia
        ForecastCriteriaLocation::create(['id' => $shipmentCriteria->id, 'location_id' => $america]); // North America
        ForecastCriteriaLocation::create(['id' => $shipmentCriteria->id, 'location_id' => $india]); // India

        ForecastCriteriaParameter::create(['forecast_criteria_id' => $shipmentCriteria->id, 'criteria_id' => 1, 'date_from' => '2017-01-01', 'date_to' => '2020-12-01', 'value' => 1, 'monthly_growth' => 0]);

    }
}
