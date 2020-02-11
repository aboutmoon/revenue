<?php

namespace App\Jobs;

use App\Models\Item;
use function foo\func;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

use App\Models\DataModel;
use App\Models\Account;
use App\Models\Location;
use App\Models\ModelResult;
use App\Models\User;
use App\Models\ForecastDevice;
use App\Models\ForecastDevicesView;
use App\Models\ForecastItem;
use App\Models\ForecastItemsView;
use App\Models\ForecastCriteriasView;
use App\Models\ForecastCriteria;
use App\Models\Project;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use PhpParser\Node\Expr\Array_;

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

const I_FOTA_ROYALTY = 9;
const C_FOTA_ROYALTY_FEE = 9;

const I_SEARCH_REVENUE_SHARING = 10;
const C_SEARCH_REVENUE_PER_1K_MAU = 10;

const I_ADS_REVENUE_SHARING = 11;
const C_MONTHLY_PAGE_VIEW = 11;
const C_ECPM = 12;
const C_ADS_REVENUE_PER_1K_ADS_DAU = 13;

CONST I_PAYMENTS_REVENUE_SHARING_STORE_V1 = 12;

const C_AVERATE_SELLING_PRICE_ASP_V1 = 20;
const C_MAU_TO_STORE_APP_VIEW_RATIO_V1 = 21;
const C_KAIPAY_COVERAGE_V1 = 22;
const C_STORE_APP_VIEW_OF_PAID_APP_V1 = 23;
const C_CONVERSION_TO_PURCHASE_STORE_V1 = 24;
CONST C_REVENUE_SHARING_CARRIER_STORE_V1 = 90;
CONST C_REVENUE_SHARING_CARRIER_OEM_V1 = 91;



const I_PAYMENTS_REVENUE_SHARING_STORE_V2 = 13;
const C_AVERATE_SELLING_PRICE_STORE_ASP_V2 = 25;
const C_MAU_TO_STORE_APP_VIEW_RATIO_V2 = 26;
const C_KAIPAY_COVERAGE_V2 = 27;
const C_STORE_APP_VIEW_OF_PAID_APP_V2 = 28;
const C_CONVERSION_TO_PURCHASE_STORE_V2 = 29;
CONST C_AGGREG_REV_SHARE_STORE_V2 = 92;
CONST C_AGGREGATOR_APP_RATIO_STORE_V2 = 93;
CONST C_APP_DEV_STORE_V2 = 94;
CONST C_KAI_APP_PAYMENT_RATIO_STORE_V2 = 86;
CONST C_BILLING_CUT_STORE_V2 = 87;
CONST C_REV_SHARE_CARRIER = 88;
CONST C_REV_SHARE_OEM = 89;

const I_PAYMENTS_REVENUE_SHARING_IAP_V2 = 14;

const C_APPS_WITH_IAP_RATIO = 30;
const C_CONVERSION_TO_PURCHASE_IAP = 31;
const C_AVERAGE_SELLING_PRICE_IAP = 32;
CONST C_PRS_IAP_CARRIER_SHARING = 79;
CONST C_PRS_IAP_CARRIER_OEM = 80;
CONST C_PRS_IAP_AGGREG_REV_SHARE = 81;
CONST C_PRS_IAP_AGGREG_APP_RATIO = 82;
CONST C_PRS_IAP_APP_DEV_REV_SHARE = 83;
CONST C_PRS_IAP_KAI_APPS_RATIO = 84;
CONST C_PRS_IAP_BILLING_CUT = 85;


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

CONST I_COST_ADS_REVENUE_SHARING = 39;

CONST C_ADS_OEM_REV_SHARE = 14;
CONST C_ADS_CARRIER_REV_SHARE = 15;
CONST C_ADS_AGGREG_REV_SHARE = 16;
CONST C_ADS_AGGREGATOR_APP_RATIO = 17;
CONST C_ADS_APP_DEV_REV_SHARE = 18;
CONST C_ADS_KAI_APP_REVENUE_RATIO = 19;

CONST I_COST_SEARCH_REVENUE_SHARING = 40;

CONST C_SRS_REVENUE_SHARING_CARRIER = 70;
CONST C_SRS_REVENUE_SHARING_OEM = 71;

CONST I_COST_PAYMENT_REVENUE_SHARING = 41;

CONST C_PRS_REVENUE_SHARING_CARRIER = 72;
CONST C_PRS_REVENUE_SHARING_OEM = 73;
CONST C_PRS_BILLING_CUT = 74;
CONST C_PRS_KAI_APPS_PAYMENT_REVENUE_RATIO = 75;
CONST C_PRS_APP_DEV_REV_SHARE = 76;
CONST C_PRS_AGGREGATOR_APP_RATIO = 77;
CONST C_PRS_AGGREGATOR_REV_SHARE = 78;


const BULK_NUMBER = 5000;


class GenerateModelResult implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $modelId;
    protected $modelVid;

    public $tries = 1;
    public $timeout = 3600;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($model_id, $model_vid)
    {
        $this->modelId = $model_id;
        $this->modelVid = $model_vid;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
//        DB::transaction(function(){
//            $dataModel = DataModel::where('id', $this->modelId)->where('vid', $this->modelVid)->first();
//            $dataModel->status = $this->job->getJobId()?$this->job->getJobId(): 0;
//            $dataModel->save();
            $this->generate();
//            $dataModel->status = 0;
//            $dataModel->save();
//        });

    }



    public function generate()
    {
        $modelId = $this->modelId;
        $modelVid = $this->modelVid;

        DB::table('forecast_devices_view')->where('model_id', $modelId)->where('model_vid', $modelVid)->delete();
        DB::table('model_results')->where('model_id', $modelId)->where('model_vid', $modelVid)->delete();

        $openMarket = Account::where('name', 'Open Market')->first();
        $indiaMarket = Location::where('name', 'India')->where('level_type', 'Market')->first();
        $projects = Project::all()->keyBy('id');
        //shipment
        $forecastDevices = ForecastDevice::all();
        $insertData = [];
        foreach ($forecastDevices as $forecastDevice) {
            array_push($insertData, [
                'model_id' => $modelId,
                'model_vid' => $modelVid,
                'location_id' => $forecastDevice->location_id,
                'market_id' => $forecastDevice->market_id,
                'project_id' => $forecastDevice->project_id,
                'confidence' => $forecastDevice->confidence,
                'i_shipment' => $forecastDevice->quantity,
                'c_shipment' => $forecastDevice->quantity,
                'date' => $forecastDevice->date
            ]);

            if (count($insertData) > BULK_NUMBER) {
                ForecastDevicesView::insert($insertData);
                $insertData = [];
            }
        }
        if ($insertData) {
            ForecastDevicesView::insert($insertData);
        }


        $forecastItems = ForecastItem::all();
        foreach ($forecastItems as $forecastItem) {
            $market_ids = $forecastItem->locations()->pluck('location_id')->toArray();
            $project_ids = Project::where(function ($q1) use ($forecastItem) {
                if ($forecastItem->oem_id) {
                    $q1->where('oem_id', $forecastItem->oem_id);
                }
                if ($forecastItem->odm_id) {
                    $q1->where('odm_id', $forecastItem->odm_id);
                }
                if ($forecastItem->carrier_id) {
                    $q1->where('carrier_id', $forecastItem->carrier_id);
                }
                if ($forecastItem->type_id) {
                    $q1->where('type_id', $forecastItem->type_id);
                }
                if ($forecastItem->licensee_id) {
                    $q1->where('licensee_id', $forecastItem->licensee_id);
                }
            })->pluck('id')->toArray();

            foreach ($forecastItem->items as $item) {
                $item_id = $item->id;
                $updateData = [];

                switch ($item_id) {
                    case I_SHIPMENT:
                        $updateData['i_shipment_mg'] = $forecastItem->monthly_growth;
                        $updateData['i_shipment_cg'] = $forecastItem->coverage;
                        break;
                    case I_INSTALL_BASE:
                        $updateData['i_install_base_mg'] = $forecastItem->monthly_growth;
                        $updateData['i_install_base_cg'] = $forecastItem->coverage;
                        break;
                    case I_ACTIVATED_DEVICE:
                        $updateData['i_activated_device_mg'] = $forecastItem->monthly_growth;
                        $updateData['i_activated_device_cg'] = $forecastItem->coverage;
                        break;
                    case I_MAU:
                        $updateData['i_mau_mg'] = $forecastItem->monthly_growth;
                        $updateData['i_mau_cg'] = $forecastItem->coverage;
                        break;
                    case  I_ADS_MAU:
                        $updateData['i_ads_dau_mg'] = $forecastItem->monthly_growth;
                        $updateData['i_ads_dau_cg'] = $forecastItem->coverage;
                        break;
                    case I_FOTA_FEE:
                        $updateData['i_fota_fee_mg'] = $forecastItem->monthly_growth;
                        $updateData['i_fota_fee_cg'] = $forecastItem->coverage;
                        break;
                    case I_FOTA_ROYALTY:
                        $updateData['i_fota_royalty_mg'] = $forecastItem->monthly_growth;
                        $updateData['i_fota_royalty_cg'] = $forecastItem->coverage;
                        break;
                    case I_SEARCH_REVENUE_SHARING:
                        $updateData['i_search_revenue_sharing_mg'] = $forecastItem->monthly_growth;
                        $updateData['i_search_revenue_sharing_cg'] = $forecastItem->coverage;
                        break;
                    case I_ADS_REVENUE_SHARING:
                        $updateData['i_ads_revenue_sharing_mg'] = $forecastItem->monthly_growth;
                        $updateData['i_ads_revenue_sharing_cg'] = $forecastItem->coverage;
                        break;
                    case I_PAYMENTS_REVENUE_SHARING_STORE_V2:
                        $updateData['i_payments_revenue_sharing_store_v2_mg'] = $forecastItem->monthly_growth;
                        $updateData['i_payments_revenue_sharing_store_v2_cg'] = $forecastItem->coverage;
                        break;
                    case I_PAYMENTS_REVENUE_SHARING_IAP_V2:
                        $updateData['i_payments_revenue_sharing_iap_mg'] = $forecastItem->monthly_growth;
                        $updateData['i_payments_revenue_sharing_iap_cg'] = $forecastItem->coverage;
                        break;
                    case I_PAYMENTS_REVENUE_SHARING:
                        $updateData['i_payments_revenue_sharing_mg'] = $forecastItem->monthly_growth;
                        $updateData['i_payments_revenue_sharing_cg'] = $forecastItem->coverage;
                        break;
                    case I_COST_3RD_PARTY_LICENSES:
                        $updateData['i_cost_3rd_party_licenses_mg'] = $forecastItem->monthly_growth;
                        $updateData['i_cost_3rd_party_licenses_cg'] = $forecastItem->coverage;
                        break;
                    case I_MAINTENANCE:
                        $updateData['i_maintenance_mg'] = $forecastItem->monthly_growth;
                        $updateData['i_maintenance_cg'] = $forecastItem->coverage;
                        break;
                    case I_NRE:
                        $updateData['i_nre_mg'] = $forecastItem->monthly_growth;
                        $updateData['i_nre_cg'] = $forecastItem->coverage;
                        break;
                    case I_APP_PRELOAD:
                        $updateData['i_app_preload_mg'] = $forecastItem->monthly_growth;
                        $updateData['i_app_preload_cg'] = $forecastItem->coverage;
                        break;
                    case I_PAYMENTS_REVENUE_SHARING_STORE_V1:
                        $updateData['i_payments_revenue_sharing_store_v1_mg'] = $forecastItem->monthly_growth;
                        $updateData['i_payments_revenue_sharing_store_v1_cg'] = $forecastItem->coverage;
                        break;
                    case I_REVENUE_3RD_PARTY_LICENSES:
                        $updateData['i_revenue_3rd_party_licenses_mg'] = $forecastItem->monthly_growth;
                        $updateData['i_revenue_3rd_party_licenses_cg'] = $forecastItem->coverage;
                        break;
                    case I_R_DEVICE_FINANCING:
                        $updateData['i_r_device_financing_mg'] = $forecastItem->monthly_growth;
                        $updateData['i_r_device_financing_cg'] = $forecastItem->coverage;
                        break;
                    case I_YEARLY_APP_PRELOAD:
                        $updateData['i_yearly_app_preload_mg'] = $forecastItem->monthly_growth;
                        $updateData['i_yearly_app_preload_cg'] = $forecastItem->coverage;
                        break;
                    case I_CARRIER_TAB_FEE:
                        $updateData['i_carrier_tab_fee_mg'] = $forecastItem->monthly_growth;
                        $updateData['i_carrier_tab_fee_cg'] = $forecastItem->coverage;
                        break;
                    case I_COST_ADS_REVENUE_SHARING:
                        $updateData['i_c_ads_revenue_sharing_mg'] = $forecastItem->monthly_growth;
                        $updateData['i_c_ads_revenue_sharing_cg'] = $forecastItem->coverage;
                        break;
                    case I_COST_SEARCH_REVENUE_SHARING:
                        $updateData['i_c_search_revenue_sharing_mg'] = $forecastItem->monthly_growth;
                        $updateData['i_c_search_revenue_sharing_cg'] = $forecastItem->coverage;
                        break;
                    case I_BILLING_COST:
                        $updateData['i_billing_cost_mg'] = $forecastItem->monthly_growth;
                        $updateData['i_billing_cost_cg'] = $forecastItem->coverage;
                        break;
                    case I_AVERTISEMENT_PLATFORM:
                        $updateData['i_avertisement_platform_mg'] = $forecastItem->monthly_growth;
                        $updateData['i_avertisement_platform_cg'] = $forecastItem->coverage;
                        break;
                    case I_FOTA_CLOUD:
                        $updateData['i_fota_cloud_mg'] = $forecastItem->monthly_growth;
                        $updateData['i_fota_cloud_cg'] = $forecastItem->coverage;
                        break;
                    case I_STORE_CLOUD:
                        $updateData['i_store_cloud_mg'] = $forecastItem->monthly_growth;
                        $updateData['i_store_cloud_cg'] = $forecastItem->coverage;
                        break;
                    case I_PUSH_CLOUD:
                        $updateData['i_push_cloud_mg'] = $forecastItem->monthly_growth;
                        $updateData['i_push_cloud_cg'] = $forecastItem->coverage;
                        break;
                    case I_FTU_SMS:
                        $updateData['i_ptu_sms_mg'] = $forecastItem->monthly_growth;
                        $updateData['i_ptu_sms_cg'] = $forecastItem->coverage;
                        break;
                    case I_COST_PAYMENT_REVENUE_SHARING:
                        $updateData['i_c_payment_revenue_sharing_mg'] = $forecastItem->monthly_growth;
                        $updateData['i_c_payment_revenue_sharing_cg'] = $forecastItem->coverage;
                        break;
                    default:
                        break;
                }

                DB::table('forecast_devices_view')
                    ->where('model_id', $modelId)
                    ->where('model_vid', $modelVid)
                    ->where(function ($q1) use ($market_ids, $project_ids, $forecastItem) {
                        if ($market_ids) {
                            $q1->whereIn('market_id', $market_ids);
                        }
                        if ($project_ids) {
                            $q1->whereIn('project_id', $project_ids);
                        }
                    })
                    ->whereIn('market_id', $market_ids)
                    ->whereIn('project_id', $project_ids)
                    ->where('date', '>=', $forecastItem->date_from)
                    ->where('date', '<=', $forecastItem->date_to)
                    ->update($updateData);
            }
        }

        $forecastCriterias = ForecastCriteria::all();
        foreach ($forecastCriterias as $forecastCriteria) {
            $market_ids = $forecastCriteria->locations()->pluck('location_id')->toArray();
            $project_ids = Project::where(function ($q1) use ($forecastCriteria) {
                if ($forecastCriteria->oem_id) {
                    $q1->where('oem_id', $forecastCriteria->oem_id);
                }
                if ($forecastCriteria->odm_id) {
                    $q1->where('odm_id', $forecastCriteria->odm_id);
                }
                if ($forecastCriteria->carrier_id) {
                    $q1->where('carrier_id', $forecastCriteria->carrier_id);
                }
                if ($forecastCriteria->type_id) {
                    $q1->where('type_id', $forecastCriteria->type_id);
                }
                if ($forecastCriteria->licensee_id) {
                    $q1->where('licensee_id', $forecastCriteria->licensee_id);
                }
            })->pluck('id')->toArray();
            $item_id = $forecastCriteria->item_id;
            $parameters = $forecastCriteria->parameters;

            foreach ($parameters as $parameter) {
                $updateData = [];
                if ($item_id == I_SHIPMENT) {
                    if ($parameter->criteria_id == C_SHIPMENT)
                        $updateData['c_shipment_mg'] = $parameter->monthly_growth;
                }

                if ($item_id == I_INSTALL_BASE) {
                    if ($parameter->criteria_id == C_CHURN_RATE) {
                        $updateData['c_chrun_rate'] = $parameter->value;
                        $updateData['c_chrun_rate_mg'] = $parameter->monthly_growth;
                    } else {
                        $updateData['c_lifetime'] = $parameter->value;
                        $updateData['c_lifetime_mg'] = $parameter->monthly_growth;
                    }
                }

                if ($item_id == I_ACTIVATED_DEVICE) {
                    if ($parameter->criteria_id == C_ACTIVATION_RATIO) {
                        $updateData['c_activation_ratio'] = $parameter->value;
                        $updateData['c_activation_ratio_mg'] = $parameter->monthly_growth;
                    }
                }

                if ($item_id == I_MAU) {
                    if ($parameter->criteria_id == C_INITIAL_MAU_RATIO) {
                        $updateData['c_initial_mau_ratio'] = $parameter->value;
                        $updateData['c_initial_mau_ratio_mg'] = $parameter->monthly_growth;
                    }
                    if ($parameter->criteria_id == C_MAU_GROWTH_FACTOR) {
                        $updateData['c_mau_growth_factor'] = $parameter->value;
                        $updateData['c_mau_growth_factor_mg'] = $parameter->monthly_growth;
                    }
                }

                if ($item_id == I_ADS_MAU) {
                    if ($parameter->criteria_id == C_ADS_DAU_FROM_MAU) {
                        $updateData['c_ads_dau_from_mau'] = $parameter->value;
                        $updateData['c_ads_dau_from_mau_mg'] = $parameter->monthly_growth;
                    }
                }

                if ($item_id == I_FOTA_FEE) {
                    if ($parameter->criteria_id == C_FOTA_FEE) {
                        $updateData['c_fota_fee'] = $parameter->value;
                        $updateData['c_fota_fee_mg'] = $parameter->monthly_growth;
                    }
                }

                if ($item_id == I_FOTA_ROYALTY) {
                    if ($parameter->criteria_id == C_FOTA_ROYALTY_FEE) {
                        $updateData['c_fota_royalty_fee'] = $parameter->value;
                        $updateData['c_fota_royalty_fee_mg'] = $parameter->monthly_growth;
                    }
                }

                if ($item_id == I_ADS_REVENUE_SHARING) {
                    if ($parameter->criteria_id == C_MONTHLY_PAGE_VIEW) {
                        $updateData['c_ads_monthly_page_view'] = $parameter->value;
                        $updateData['c_ads_monthly_page_view_mg'] = $parameter->monthly_growth;
                    }
                    if ($parameter->criteria_id == C_ADS_REVENUE_PER_1K_ADS_DAU) {
                        $updateData['c_ads_revenue_per_1k_ads_dau'] = $parameter->value;
                        $updateData['c_ads_revenue_per_1k_ads_dau_mg'] = $parameter->monthly_growth;
                    }
                    if ($parameter->criteria_id == C_ECPM) {
                        $updateData['c_ads_ecpm'] = $parameter->value;
                        $updateData['c_ads_ecpm_mg'] = $parameter->monthly_growth;
                    }
                }

                if ($item_id == I_SEARCH_REVENUE_SHARING) {
                    if ($parameter->criteria_id == C_SEARCH_REVENUE_PER_1K_MAU) {
                        $updateData['c_search_revenue_per_1k_mau'] = $parameter->value;
                        $updateData['c_search_revenue_per_1k_mau_mg'] = $parameter->monthly_growth;
                    }
                }

                if ($item_id == I_NRE) {
                    if ($parameter->criteria_id == C_MONTHLY_TEAM_PRICE) {
                        $updateData['c_monthly_team_price'] = $parameter->value;
                        $updateData['c_monthly_team_price_mg'] = $parameter->monthly_growth;
                    }
                }

                if ($item_id == I_MAINTENANCE) {
                    if ($parameter->criteria_id == C_YEARLY_MAINTENANCE_PRICE) {
                        $updateData['c_yearly_maintenance_price'] = $parameter->value;
                        $updateData['c_yearly_maintenance_price_mg'] = $parameter->monthly_growth;
                    }
                }


                if ($item_id == I_PAYMENTS_REVENUE_SHARING_STORE_V1) {
                    if ($parameter->criteria_id == C_AVERATE_SELLING_PRICE_ASP_V1) {
                        $updateData['c_store_average_selling_price_v1'] = $parameter->value;
                        $updateData['c_store_average_selling_price_v1_mg'] = $parameter->monthly_growth;
                    }
                    if ($parameter->criteria_id == C_MAU_TO_STORE_APP_VIEW_RATIO_V1) {
                        $updateData['c_mau_to_store_app_view_ratio_v1'] = $parameter->value;
                        $updateData['c_mau_to_store_app_view_ratio_v1_mg'] = $parameter->monthly_growth;
                    }
                    if ($parameter->criteria_id == C_KAIPAY_COVERAGE_V1) {
                        $updateData['c_kai_pay_coverage_v1'] = $parameter->value;
                        $updateData['c_kai_pay_coverage_v1_mg'] = $parameter->monthly_growth;
                    }
                    if ($parameter->criteria_id == C_STORE_APP_VIEW_OF_PAID_APP_V1) {
                        $updateData['c_store_app_view_of_paid_app_v1'] = $parameter->value;
                        $updateData['c_store_app_view_of_paid_app_v1_mg'] = $parameter->monthly_growth;
                    }
                    if ($parameter->criteria_id == C_CONVERSION_TO_PURCHASE_STORE_V1) {
                        $updateData['c_conversion_to_purchase_store_v1'] = $parameter->value;
                        $updateData['c_conversion_to_purchase_store_v1_mg'] = $parameter->monthly_growth;
                    }
                    if ($parameter->criteria_id == C_REVENUE_SHARING_CARRIER_STORE_V1) {
                        $updateData['c_prs_store_carrier_sharing_v1'] = $parameter->value;
                        $updateData['c_prs_store_carrier_sharing_mg_v1'] = $parameter->monthly_growth;
                    }
                    if ($parameter->criteria_id == C_REVENUE_SHARING_CARRIER_OEM_V1) {
                        $updateData['c_prs_store_oem_sharing_v1'] = $parameter->value;
                        $updateData['c_prs_store_oem_sharing_mg_v1'] = $parameter->monthly_growth;
                    }

                }

                if ($item_id == I_PAYMENTS_REVENUE_SHARING_STORE_V2) {
                    if ($parameter->criteria_id == C_AVERATE_SELLING_PRICE_STORE_ASP_V2) {
                        $updateData['c_store_average_selling_price_v2'] = $parameter->value;
                        $updateData['c_store_average_selling_price_v2_mg'] = $parameter->monthly_growth;
                    }
                    if ($parameter->criteria_id == C_MAU_TO_STORE_APP_VIEW_RATIO_V2) {
                        $updateData['c_mau_to_store_app_view_ratio_v2'] = $parameter->value;
                        $updateData['c_mau_to_store_app_view_ratio_v2_mg'] = $parameter->monthly_growth;
                    }
                    if ($parameter->criteria_id == C_KAIPAY_COVERAGE_V2) {
                        $updateData['c_kai_pay_coverage_v2'] = $parameter->value;
                        $updateData['c_kai_pay_coverage_v2_mg'] = $parameter->monthly_growth;
                    }
                    if ($parameter->criteria_id == C_STORE_APP_VIEW_OF_PAID_APP_V2) {
                        $updateData['c_store_app_view_of_paid_app_v2'] = $parameter->value;
                        $updateData['c_store_app_view_of_paid_app_v2_mg'] = $parameter->monthly_growth;
                    }
                    if ($parameter->criteria_id == C_CONVERSION_TO_PURCHASE_STORE_V2) {
                        $updateData['c_conversion_to_purchase_store_v2'] = $parameter->value;
                        $updateData['c_conversion_to_purchase_store_v2_mg'] = $parameter->monthly_growth;
                    }
                    if ($parameter->criteria_id == C_AGGREG_REV_SHARE_STORE_V2) {
                        $updateData['c_prs_aggreg_rev_share_v2'] = $parameter->value;
                        $updateData['c_prs_aggreg_rev_share_mg_v2'] = $parameter->monthly_growth;
                    }
                    if ($parameter->criteria_id == C_AGGREGATOR_APP_RATIO_STORE_V2) {
                        $updateData['c_prs_aggreg_app_ratio_v2'] = $parameter->value;
                        $updateData['c_prs_aggreg_app_ratio_mg_v2'] = $parameter->monthly_growth;
                    }
                    if ($parameter->criteria_id == C_APP_DEV_STORE_V2) {
                        $updateData['c_prs_app_dev_store_v2'] = $parameter->value;
                        $updateData['c_prs_app_dev_store_mg_v2'] = $parameter->monthly_growth;
                    }
                    if ($parameter->criteria_id == C_REV_SHARE_CARRIER) {
                        $updateData['c_prs_store_carrier_sharing_v2'] = $parameter->value;
                        $updateData['c_prs_store_carrier_sharing_mg_v2'] = $parameter->monthly_growth;
                    }
                    if ($parameter->criteria_id == C_REV_SHARE_OEM) {
                        $updateData['c_prs_store_oem_sharing_v2'] = $parameter->value;
                        $updateData['c_prs_store_oem_sharing_mg_v2'] = $parameter->monthly_growth;
                    }
                    if ($parameter->criteria_id == C_KAI_APP_PAYMENT_RATIO_STORE_V2) {
                        $updateData['c_prs_kai_app_ratio_store_v2'] = $parameter->value;
                        $updateData['c_prs_kai_app_ratio_store_mg_v2'] = $parameter->monthly_growth;
                    }
                    if ($parameter->criteria_id == C_BILLING_CUT_STORE_V2) {
                        $updateData['c_prs_billing_cut_store_v2'] = $parameter->value;
                        $updateData['c_prs_billing_cut_store_mg_v2'] = $parameter->monthly_growth;
                    }
                }


                if ($item_id == I_PAYMENTS_REVENUE_SHARING_IAP_V2) {
                    if ($parameter->criteria_id == C_APPS_WITH_IAP_RATIO) {
                        $updateData['c_apps_with_iap_ratio'] = $parameter->value;
                        $updateData['c_apps_with_iap_ratio_mg'] = $parameter->monthly_growth;
                    }
                    if ($parameter->criteria_id == C_CONVERSION_TO_PURCHASE_IAP) {
                        $updateData['c_conversion_to_purchase_iap'] = $parameter->value;
                        $updateData['c_conversion_to_purchase_iap_mg'] = $parameter->monthly_growth;
                    }
                    if ($parameter->criteria_id == C_AVERAGE_SELLING_PRICE_IAP) {
                        $updateData['c_iap_average_selling_price'] = $parameter->value;
                        $updateData['c_iap_average_selling_price_mg'] = $parameter->monthly_growth;
                    }
                    if ($parameter->criteria_id == C_PRS_IAP_CARRIER_SHARING) {
                        $updateData['c_prs_carrier_sharing_iap'] = $parameter->value;
                        $updateData['c_prs_carrier_sharing_mg_iap'] = $parameter->monthly_growth;
                    }
                    if ($parameter->criteria_id == C_PRS_IAP_CARRIER_OEM) {
                        $updateData['c_prs_oem_sharing_iap'] = $parameter->value;
                        $updateData['c_prs_oem_sharing_mg_iap'] = $parameter->monthly_growth;
                    }
                    if ($parameter->criteria_id == C_PRS_IAP_AGGREG_REV_SHARE) {
                        $updateData['c_prs_aggrev_rev_share_iap'] = $parameter->value;
                        $updateData['c_prs_aggrev_rev_share_iap_mg'] = $parameter->monthly_growth;
                    }
                    if ($parameter->criteria_id == C_PRS_IAP_AGGREG_APP_RATIO) {
                        $updateData['c_prs_aggregator_app_ratio_iap'] = $parameter->value;
                        $updateData['c_prs_aggregator_app_ratio_iap_mg'] = $parameter->monthly_growth;
                    }
                    if ($parameter->criteria_id == C_PRS_IAP_APP_DEV_REV_SHARE) {
                        $updateData['c_prs_app_dev_or_content_provider_rev_share_iap'] = $parameter->value;
                        $updateData['c_prs_app_dev_or_content_provider_rev_share_iap_mg'] = $parameter->monthly_growth;
                    }
                    if ($parameter->criteria_id == C_PRS_IAP_KAI_APPS_RATIO) {
                        $updateData['c_prs_apps_payment_revenue_ratio_iap'] = $parameter->value;
                        $updateData['c_prs_apps_payment_revenue_ratio_iap_mg'] = $parameter->monthly_growth;
                    }
                    if ($parameter->criteria_id == C_PRS_IAP_BILLING_CUT) {
                        $updateData['c_prs_billing_cut_iap'] = $parameter->value;
                        $updateData['c_prs_billing_cut_iap_mg'] = $parameter->monthly_growth;
                    }

                }

                if ($item_id == I_REVENUE_3RD_PARTY_LICENSES) {
                    if ($parameter->criteria_id == C_TOUCHPAL_LICESES_FEE) {
                        $updateData['c_touchpal_licenses_fee'] = $parameter->value;
                        $updateData['c_touchpal_licenses_fee_mg'] = $parameter->monthly_growth;
                    }
                }

                if ($item_id == I_R_DEVICE_FINANCING) {
                    if ($parameter->criteria_id == C_KTM_FEE) {
                        $updateData['c_df_kim_fee'] = $parameter->value;
                        $updateData['c_df_kim_fee_mg'] = $parameter->monthly_growth;
                    }
                    if ($parameter->criteria_id == C_CONTRACT_PERIOD) {
                        $updateData['c_df_contract_period'] = $parameter->value;
                        $updateData['c_df_contract_period_mg'] = $parameter->monthly_growth;
                    }
                    if ($parameter->criteria_id == C_MONTHLY_CHRUN_RATE) {
                        $updateData['c_df_monthly_chrun_rate'] = $parameter->value;
                        $updateData['c_df_monthly_chrun_rate_mg'] = $parameter->monthly_growth;
                    }
                }

                if ($item_id == I_YEARLY_APP_PRELOAD) {
                    if ($parameter->criteria_id == C_YEARLY_PLACEMENT_FEE) {
                        $updateData['c_yearly_placement_fee'] = $parameter->value;
                        $updateData['c_yearly_placement_fee_mg'] = $parameter->monthly_growth;
                    }

                }

                if ($item_id == I_CARRIER_TAB_FEE) {
                    if ($parameter->criteria_id == C_CARRIER_TAB_FEE_CARRIER) {
                        $updateData['c_carrier_tab_fee_carrier'] = $parameter->value;
                        $updateData['c_carrier_tab_fee_carrier_mg'] = $parameter->monthly_growth;
                    }

                    if ($parameter->criteria_id == C_CARRIER_TAB_FEE_OPEN_MARKET) {
                        $updateData['c_carrier_tab_fee_om'] = $parameter->value;
                        $updateData['c_carrier_tab_fee_om_mg'] = $parameter->monthly_growth;
                    }

                }

                if ($item_id == I_APP_PRELOAD) {
                    if ($parameter->criteria_id == C_PLACEMENT_FEE_CARRIER) {
                        $updateData['c_placement_fee_carrier'] = $parameter->value;
                        $updateData['c_placement_fee_carrier_mg'] = $parameter->monthly_growth;
                    }

                    if ($parameter->criteria_id == C_PRELOAD_APP_ACTIVATION_RATE_CARRIER) {
                        $updateData['c_preload_app_act_rate_carrier'] = $parameter->value;
                        $updateData['c_preload_app_act_rate_carrier_mg'] = $parameter->monthly_growth;
                    }

                    if ($parameter->criteria_id == C_PLACEMENT_FEE_OPEN_MARKET) {
                        $updateData['c_placement_fee_om'] = $parameter->value;
                        $updateData['c_placement_fee_om_mg'] = $parameter->monthly_growth;
                    }

                    if ($parameter->criteria_id == C_PRELOAD_APP_ACTIVATION_RATE_OPEN_MARKET) {
                        $updateData['c_preload_app_act_rate_om'] = $parameter->value;
                        $updateData['c_preload_app_act_rate_om_mg'] = $parameter->monthly_growth;
                    }

                }

                if ($item_id == I_COST_ADS_REVENUE_SHARING) {
                    if ($parameter->criteria_id == C_ADS_OEM_REV_SHARE) {
                        $updateData['c_ads_oem_rev_share'] = $parameter->value;
                        $updateData['c_ads_oem_rev_share_mg'] = $parameter->monthly_growth;
                    }

                    if ($parameter->criteria_id == C_ADS_CARRIER_REV_SHARE) {
                        $updateData['c_ads_carrier_rev_share'] = $parameter->value;
                        $updateData['c_ads_carrier_rev_share_mg'] = $parameter->monthly_growth;
                    }

                    if ($parameter->criteria_id == C_ADS_AGGREG_REV_SHARE) {
                        $updateData['c_ads_aggreg_rev_share'] = $parameter->value;
                        $updateData['c_ads_aggreg_rev_share_mg'] = $parameter->monthly_growth;
                    }

                    if ($parameter->criteria_id == C_ADS_AGGREGATOR_APP_RATIO) {
                        $updateData['c_ads_aggregator_app_ratio'] = $parameter->value;
                        $updateData['c_ads_aggregator_app_ratio_mg'] = $parameter->monthly_growth;
                    }

                    if ($parameter->criteria_id == C_ADS_APP_DEV_REV_SHARE) {
                        $updateData['c_ads_app_dev_or_content_provider_rev_share'] = $parameter->value;
                        $updateData['c_ads_app_dev_or_content_provider_rev_share_mg'] = $parameter->monthly_growth;
                    }

                    if ($parameter->criteria_id == C_ADS_KAI_APP_REVENUE_RATIO) {
                        $updateData['c_ads_kai_apps_ads_revenue_ratio'] = $parameter->value;
                        $updateData['c_ads_kai_apps_ads_revenue_ratio_mg'] = $parameter->monthly_growth;
                    }
                }

                if ($item_id == I_BILLING_COST) {
                    if ($parameter->criteria_id == C_VAT) {
                        $updateData['c_vat'] = $parameter->value;
                        $updateData['c_vat_mg'] = $parameter->monthly_growth;
                    }
                    if ($parameter->criteria_id == C_WITHOLDING_TAXES) {
                        $updateData['c_witholding_taxes'] = $parameter->value;
                        $updateData['c_witholding_taxes_mg'] = $parameter->monthly_growth;
                    }
                }

                if ($item_id == I_AVERTISEMENT_PLATFORM) {
                    if ($parameter->criteria_id == C_AVERTISEMENT_PLATFORM_COST) {
                        $updateData['c_avertisement_platform_cost'] = $parameter->value;
                        $updateData['c_avertisement_platform_cost_mg'] = $parameter->monthly_growth;
                    }
                }

                if ($item_id == I_FOTA_CLOUD) {
                    if ($parameter->criteria_id == C_FOTA_COST) {
                        $updateData['c_fota_cloud'] = $parameter->value;
                        $updateData['c_fota_cloud_mg'] = $parameter->monthly_growth;
                    }
                }

                if ($item_id == I_STORE_CLOUD) {
                    if ($parameter->criteria_id == C_STORE_COST) {
                        $updateData['c_store_cloud'] = $parameter->value;
                        $updateData['c_store_cloud_mg'] = $parameter->monthly_growth;
                    }
                }

                if ($item_id == I_PUSH_CLOUD) {
                    if ($parameter->criteria_id == C_PUSH_CLOUD) {
                        $updateData['c_push_cloud'] = $parameter->value;
                        $updateData['c_push_cloud_mg'] = $parameter->monthly_growth;
                    }
                }

                if ($item_id == I_FTU_SMS) {
                    if ($parameter->criteria_id == C_SMS_COST) {
                        $updateData['c_ptu_sms'] = $parameter->value;
                        $updateData['c_ptu_sms_mg'] = $parameter->monthly_growth;
                    }
                }

                if ($item_id == I_COST_3RD_PARTY_LICENSES) {
                    if ($parameter->criteria_id == C_TOUCHPAL_LICENSES_COST) {
                        $updateData['c_touchpal_licenses_cost'] = $parameter->value;
                        $updateData['c_touchpal_licenses_cost_mg'] = $parameter->monthly_growth;
                    }
                }

                if ($item_id == I_COST_SEARCH_REVENUE_SHARING) {
                    if ($parameter->criteria_id == C_SRS_REVENUE_SHARING_CARRIER) {
                        $updateData['c_srs_revenue_sharing_carrier'] = $parameter->value;
                        $updateData['c_srs_revenue_sharing_carrier_mg'] = $parameter->monthly_growth;
                    }

                    if ($parameter->criteria_id == C_SRS_REVENUE_SHARING_OEM) {
                        $updateData['c_srs_revenue_sharing_oem'] = $parameter->value;
                        $updateData['c_srs_revenue_sharing_oem_mg'] = $parameter->monthly_growth;
                    }
                }

                if ($item_id == I_COST_PAYMENT_REVENUE_SHARING) {
                    if ($parameter->criteria_id == C_PRS_AGGREGATOR_APP_RATIO) {
                        $updateData['c_prs_aggregator_app_ratio'] = $parameter->value;
                        $updateData['c_prs_aggregator_app_ratio_mg'] = $parameter->monthly_growth;
                    }

                    if ($parameter->criteria_id == C_PRS_AGGREGATOR_REV_SHARE) {
                        $updateData['c_prs_aggreg_rev_share'] = $parameter->value;
                        $updateData['c_prs_aggreg_rev_share_mg'] = $parameter->monthly_growth;
                    }

                    if ($parameter->criteria_id == C_PRS_APP_DEV_REV_SHARE) {
                        $updateData['c_prs_app_dev_or_content_provider_rev_share'] = $parameter->value;
                        $updateData['c_prs_app_dev_or_content_provider_rev_share_mg'] = $parameter->monthly_growth;
                    }

                    if ($parameter->criteria_id == C_PRS_BILLING_CUT) {
                        $updateData['c_prs_billing_cut'] = $parameter->value;
                        $updateData['c_prs_billing_cut_mg'] = $parameter->monthly_growth;
                    }

                    if ($parameter->criteria_id == C_PRS_KAI_APPS_PAYMENT_REVENUE_RATIO) {
                        $updateData['c_prs_kai_apps_prs_revenue_ratio'] = $parameter->value;
                        $updateData['c_prs_kai_apps_prs_revenue_ratio_mg'] = $parameter->monthly_growth;
                    }

                    if ($parameter->criteria_id == C_PRS_REVENUE_SHARING_CARRIER) {
                        $updateData['c_prs_carrier_rev_share'] = $parameter->value;
                        $updateData['c_prs_carrier_rev_share_mg'] = $parameter->monthly_growth;
                    }

                    if ($parameter->criteria_id == C_PRS_REVENUE_SHARING_OEM) {
                        $updateData['c_prs_oem_rev_share'] = $parameter->value;
                        $updateData['c_prs_oem_rev_share_mg'] = $parameter->monthly_growth;
                    }
                }
                    DB::table('forecast_devices_view')
                        ->where('model_id', $modelId)
                        ->where('model_vid', $modelVid)
                        ->whereIn('market_id', $market_ids)
                        ->whereIn('project_id', $project_ids)
                        ->where('date', '>=', $parameter->date_from)
                        ->where('date', '<=', $parameter->date_to)
                        ->update($updateData);
                }
            }


            $forecastDeviceViews = ForecastDevicesView::all();

            $locationGroups = [];
            foreach ($forecastDeviceViews as $forecastDeviceView) {
                $locationGroups[$forecastDeviceView->location_id][$forecastDeviceView->project_id][$forecastDeviceView->date] = $forecastDeviceView;
            }

            $insertData = [];
            foreach ($locationGroups as $projectGroups) {
                foreach ($projectGroups as $dateGroups) {
                    $count = 0;
                    $prevDateGroup = null;
                    foreach ($dateGroups as $date => $dateGroup) {
                        bcscale(30);

                        $month = Carbon::parse($date)->month - 1;

                        //install base

                        {
                            $chrun_rate = bcmul($dateGroup->c_chrun_rate, bcpow(bcadd(1, $dateGroup->c_chrun_rate_mg), $month));
                            $coverage = bcmul($dateGroup->i_install_base_cg, bcpow(bcadd(1, $dateGroup->i_install_base_mg), $month));
                            $lifetime = $dateGroup->c_lifetime;

                            if ($count == 0) {

                                $dateGroup->i_install_base = $dateGroup->i_shipment;

                            } elseif ($count <= $lifetime) {

                                $dateGroup->i_install_base = bcadd(bcmul($prevDateGroup->i_install_base, bcsub(1, $chrun_rate)), $dateGroup->i_shipment);

                            } elseif ($count > $lifetime) {

                                $d = Carbon::parse($date)->subMonths($lifetime)->toDateString();
                                $shipment = $dateGroups[$d] ? $dateGroups[$d]->i_shipment : 0;

                                $result = bcsub(bcadd(bcmul($prevDateGroup->i_install_base, bcsub(1, $chrun_rate)), $dateGroup->i_shipment), $shipment);
                                $dateGroup->i_install_base = $result > 0 ? $result : 0;
                            }

                            $dateGroup->i_install_base = bcmul($dateGroup->i_install_base, $coverage);
                        }



                        // activated device

                        {
                            $installBase = $dateGroup->i_install_base;
                            $activationRatio = $dateGroup->c_activation_ratio;
                            $activationRatioMG = bcpow(1 + $dateGroup->c_activation_ratio_mg, $month);
                            $mauGrowthFactor = $dateGroup->c_mau_growth_factor;
                            $mauGrowthFactorMG = bcpow(1 + $dateGroup->c_mau_growth_factor_mg, $month);
                            $coverage = bcmul($dateGroup->i_activated_device_cg, bcpow(bcadd(1, $dateGroup->i_activated_device_mg), $month));
                        }
                        $dateGroup->i_activated_device = bcmul(bcmul($installBase, $activationRatio), $activationRatioMG);

                        if ($count == 0 || bccomp($prevDateGroup->i_activated_device, 0) == 0) {
                            $mauHelper = bcmul($dateGroup->i_activated_device, $dateGroup->c_mau_growth_factor);
                        } else {
                            $year = Carbon::parse($date)->year;
                            $activatedDeviceDiff = bcsub($dateGroup->i_activated_device, $prevDateGroup->i_activated_device);

                            if (bccomp($activatedDeviceDiff, 0) >= 0 && $year == 2020) {
                                $mauHelper = bcadd(bcmul($prevDateGroup->i_activated_device, $mauGrowthFactor), bcmul($mauGrowthFactorMG, bcmul($activatedDeviceDiff, $mauGrowthFactor)));
                            } else {
                                $mauHelper = bcadd(bcmul($prevDateGroup->i_activated_device, $mauGrowthFactor), bcmul($activatedDeviceDiff, $mauGrowthFactor));
                            }
                        }

                        $dateGroup->i_mau = bccomp($mauHelper, $dateGroup->i_install_base) > 0 ? $dateGroup->i_install_base : $mauHelper;
                        $mau = $dateGroup->i_mau;
                        $dateGroup->i_mau = bcmul($dateGroup->i_mau, $coverage);

                        // ads dau
                        $adsDauFromMau = $dateGroup->c_ads_dau_from_mau;
                        $adsDauFromMauMG = bcpow(bcadd(1, $dateGroup->c_ads_dau_from_mau_mg), $month);
                        $coverage = bcmul($dateGroup->i_ads_dau_cg, bcpow(bcadd(1, $dateGroup->i_ads_dau_mg), $month));

                        $adsDAU = bcmul(bcmul($mau, $adsDauFromMau), $adsDauFromMauMG);
                        $dateGroup->i_ads_dau = bcmul(bcmul(bcmul($dateGroup->i_mau, $adsDauFromMau), $adsDauFromMauMG), $dateGroup->i_ads_revenue_sharing_cg);
                        $dateGroup->i_ads_dau = bcmul($dateGroup->i_ads_dau, $coverage);

                        // fota fee
                        $fotaFee = $dateGroup->c_fota_fee;
                        $fotaFeeMG = bcpow(bcadd(1, $dateGroup->c_fota_fee_mg), $month);
                        $coverage = bcmul($dateGroup->i_fota_fee_cg, bcpow(bcadd(1, $dateGroup->i_fota_fee_mg), $month));

                        $dateGroup->i_fota_fee = bcmul(bcmul($dateGroup->i_shipment, $fotaFee), $fotaFeeMG);
                        $dateGroup->i_fota_fee = bcmul($dateGroup->i_fota_fee, $coverage);

                        $fotaRoyaltyFee = $dateGroup->c_fota_royalty_fee;
                        $fotaRoyaltyFeeMG = bcpow(bcadd(1, $dateGroup->c_fota_royalty_fee_mg), $month);
                        $coverage = bcmul($dateGroup->i_fota_royalty_cg, bcpow(bcadd(1, $dateGroup->i_fota_royalty_mg), $month));
                        $dateGroup->i_fota_royalty = bcmul(bcmul($dateGroup->i_shipment, $fotaRoyaltyFee), $fotaRoyaltyFeeMG);
                        $dateGroup->i_fota_royalty = bcmul($dateGroup->i_fota_royalty, $coverage);


                        // search revenue sharing
                        $searchRevenuePer1KMau = $dateGroup->c_search_revenue_per_1k_mau;
                        $searchRevenuePer1KMauMG = bcpow(bcadd(1, $dateGroup->c_search_revenue_per_1k_mau_mg), $month);
                        $coverage = bcmul($dateGroup->i_search_revenue_sharing_cg, bcpow(bcadd(1, $dateGroup->i_search_revenue_sharing_mg), $month));
                        $dateGroup->i_search_revenue_sharing = bcdiv(bcmul(bcmul($dateGroup->i_mau, $searchRevenuePer1KMau), $searchRevenuePer1KMauMG), 1000);
                        $dateGroup->i_search_revenue_sharing = bcmul($dateGroup->i_search_revenue_sharing, $coverage);

                        // ads revenue sharing
                        $adsRevenuePer1KAdsDau = $dateGroup->c_ads_revenue_per_1k_ads_dau;
                        $adsRevenuePer1KAdsDauMG = bcpow(bcadd($dateGroup->c_ads_revenue_per_1k_ads_dau_mg, 1), $month);
                        $adsMonthlyPageView = $dateGroup->c_ads_monthly_page_view;
                        $adsMonthlyPageViewMG = bcpow(bcadd($dateGroup->c_ads_monthly_page_view_mg, 1), $month);
                        $adsEcpm = $dateGroup->c_ads_ecpm;
                        $adsEcpmMG = bcpow(bcadd($dateGroup->c_ads_ecpm_mg, 1), $month);
                        $coverage = bcmul($dateGroup->i_ads_revenue_sharing_cg, bcpow(bcadd($dateGroup->i_ads_revenue_sharing_mg, 1), $month));
                        $adsRevenueSharing = bcadd(bcdiv(bcmul(bcmul(bcmul(bcmul($dateGroup->i_mau, $adsMonthlyPageView), $adsMonthlyPageViewMG), $adsEcpm), $adsEcpmMG), 1000), bcdiv(bcmul(bcmul(bcmul($adsDAU, $adsRevenuePer1KAdsDau), $adsRevenuePer1KAdsDauMG), 30), 1000));
                        $dateGroup->i_ads_revenue_sharing = bcmul($adsRevenueSharing, $coverage);

                        // nre
                        $monthlyTeamPrice = $dateGroup->c_monthly_team_price;
                        $monthlyTeamPriceMG = bcpow(bcadd($dateGroup->c_monthly_team_price_mg, 1), $month);
                        $coverage = bcmul($dateGroup->i_nre_cg, bcpow(bcadd(1, $dateGroup->i_nre_mg), $month));

                        $dateGroup->i_nre = bcmul($monthlyTeamPrice, $monthlyTeamPriceMG);
                        $dateGroup->i_nre = bcmul($dateGroup->i_nre, $coverage);

                        // maintenance
                        $yearlyMaintenancePrice = $dateGroup->c_yearly_maintenance_price;
                        $yearlyMaintenancePriceMG = bcpow(bcadd(1, $dateGroup->c_yearly_maintenance_price_mg), $month);
                        $coverage = bcmul($dateGroup->i_maintenance_cg, bcpow(bcadd(1, $dateGroup->i_maintenance_mg), $month));

                        $dateGroup->i_maintenance = bcdiv(bcmul($yearlyMaintenancePrice, $yearlyMaintenancePriceMG), 12);
                        $dateGroup->i_maintenance = bcmul($dateGroup->i_maintenance, $coverage);

                        //payment store v1
                        {
                            $averageSellingPriceV1 = $dateGroup->c_store_average_selling_price_v1;
                            $averageSellingPriceMGV1 = bcpow(bcadd(1, $dateGroup->c_store_average_selling_price_v1_mg), $month);
                            $mauToStoreAppViewRatioV1 = $dateGroup->c_mau_to_store_app_view_ratio_v1;
                            $mauToStoreAppViewRatioMGV1 = bcpow(bcadd(1, $dateGroup->c_mau_to_store_app_view_ratio_v1_mg), $month);
                            $kaiPayCoverageV1 = $dateGroup->c_kai_pay_coverage_v1;
                            $kaiPayCoverageMGV1 = bcpow(bcadd(1, $dateGroup->c_kai_pay_coverage_v1_mg), $month);
                            $storeAppViewOfPaidAppV1 = $dateGroup->c_store_app_view_of_paid_app_v1;
                            $storeAppViewOfPaidAppMGV1 = bcpow(bcadd(1, $dateGroup->c_store_app_view_of_paid_app_v1_mg), $month);
                            $conversionToPurchaseStoreV1 = $dateGroup->c_conversion_to_purchase_store_v1;
                            $conversionToPurchaseStoreMGV1 = bcpow(bcadd(1, $dateGroup->c_conversion_to_purchase_store_v1_mg), 1);

                            $coverage = bcmul($dateGroup->i_payments_revenue_sharing_store_v1_cg, bcpow(bcadd(1, $dateGroup->i_payments_revenue_sharing_store_v1_mg), $month));

                            $dateGroup->i_payments_revenue_sharing_store_v1 = bcmul($dateGroup->i_mau, bcmul(bcmul(bcmul(bcmul(bcmul($averageSellingPriceV1, $averageSellingPriceMGV1), bcmul($mauToStoreAppViewRatioV1, $mauToStoreAppViewRatioMGV1)), bcmul($kaiPayCoverageV1, $kaiPayCoverageMGV1)), bcmul($storeAppViewOfPaidAppV1, $storeAppViewOfPaidAppMGV1)), bcmul($conversionToPurchaseStoreV1, $conversionToPurchaseStoreMGV1)));
                            $dateGroup->i_payments_revenue_sharing_store_v1 = bcmul($dateGroup->i_payments_revenue_sharing_store_v1, $coverage);
                        }

                        //payment store v2
                        {
                            $averageSellingPriceV2 = $dateGroup->c_store_average_selling_price_v2;
                            $averageSellingPriceMGV2 = bcpow(bcadd(1, $dateGroup->c_store_average_selling_price_v2_mg), $month);
                            $mauToStoreAppViewRatioV2 = $dateGroup->c_mau_to_store_app_view_ratio_v2;
                            $mauToStoreAppViewRatioMGV2 = bcpow(bcadd(1, $dateGroup->c_mau_to_store_app_view_ratio_v2_mg), $month);
                            $kaiPayCoverageV2 = $dateGroup->c_kai_pay_coverage_v2;
                            $kaiPayCoverageMGV2 = bcpow(bcadd(1, $dateGroup->c_kai_pay_coverage_v2_mg), $month);
                            $storeAppViewOfPaidAppV2 = $dateGroup->c_store_app_view_of_paid_app_v2;
                            $storeAppViewOfPaidAppMGV2 = bcpow(bcadd(1, $dateGroup->c_store_app_view_of_paid_app_v2_mg), $month);
                            $conversionToPurchaseStoreV2 = $dateGroup->c_conversion_to_purchase_store_v2;
                            $conversionToPurchaseStoreMGV2 = bcpow(bcadd(1, $dateGroup->c_conversion_to_purchase_store_v2_mg), 1);

                            $coverage = bcmul($dateGroup->i_payments_revenue_sharing_store_v2_cg, bcpow(bcadd(1, $dateGroup->i_payments_revenue_sharing_store_v2_mg), $month));

                            $dateGroup->i_payments_revenue_sharing_store_v2 = bcmul($dateGroup->i_mau, bcmul(bcmul(bcmul(bcmul(bcmul($averageSellingPriceV2, $averageSellingPriceMGV2), bcmul($mauToStoreAppViewRatioV2, $mauToStoreAppViewRatioMGV2)), bcmul($kaiPayCoverageV2, $kaiPayCoverageMGV2)), bcmul($storeAppViewOfPaidAppV2, $storeAppViewOfPaidAppMGV2)), bcmul($conversionToPurchaseStoreV2, $conversionToPurchaseStoreMGV2)));
                            $dateGroup->i_payments_revenue_sharing_store_v2 = bcmul($dateGroup->i_payments_revenue_sharing_store_v2, $coverage);
                        }

                        // payment iap v2
                        {
                            $appsWithIapRatio = $dateGroup->c_apps_with_iap_ratio;
                            $appsWithIapRatioMG = bcpow(bcadd(1, $dateGroup->c_apps_with_iap_ratio_mg), $month);
                            $conversionToPurchaseIap = $dateGroup->c_conversion_to_purchase_iap;
                            $conversionToPurchaseIapMG = bcpow(bcadd(1, $dateGroup->c_conversion_to_purchase_iap_mg), $month);
                            $iapAverageSellingPrice = $dateGroup->c_iap_average_selling_price;
                            $iapAverageSellingPriceMG = bcpow(bcadd(1, $dateGroup->c_iap_average_selling_price_mg), $month);
                            $coverage = bcmul($dateGroup->i_payments_revenue_sharing_iap_cg, bcpow(bcadd(1, $dateGroup->i_payments_revenue_sharing_iap_mg), $month));

                            $dateGroup->i_payments_revenue_sharing_iap = bcmul(30, bcmul($adsDAU, bcmul(bcmul(bcmul($appsWithIapRatio, $appsWithIapRatioMG), bcmul($conversionToPurchaseIap, $conversionToPurchaseIapMG)), bcmul($iapAverageSellingPrice, $iapAverageSellingPriceMG))));

                            $dateGroup->i_payments_revenue_sharing_iap = bcmul($coverage, $dateGroup->i_payments_revenue_sharing_iap);
                        }

                        //(revenue)3rd party license
                        {
                            $touchpalLicensesFee = $dateGroup->c_touchpal_licenses_fee;
                            $touchpalLicensesFeeMG = bcpow(bcadd(1, $dateGroup->c_touchpal_licenses_fee_mg), $month);

                            $coverage = bcmul($dateGroup->i_revenue_3rd_party_licenses_cg, bcpow(bcadd(1, $dateGroup->i_revenue_3rd_party_licenses_mg), $month));

                            $dateGroup->i_revenue_3rd_party_licenses = bcmul(bcmul($touchpalLicensesFee, $touchpalLicensesFeeMG), $dateGroup->i_shipment);
                            $dateGroup->i_revenue_3rd_party_licenses = bcmul($coverage, $dateGroup->i_revenue_3rd_party_licenses);
                        }

                        //(revenue) device finance
                        {
                            $dfKimFee = $dateGroup->c_df_kim_fee;
                            $dfKimFeeMG = bcpow(bcadd(1, $dateGroup->c_df_kim_fee_mg), $month);
                            $dfContractPeriod = $dateGroup->c_df_contract_period;
                            $dfContractPeriodMG = bcpow(bcadd(1, $dateGroup->c_df_contract_period_mg), $month);
                            $dfMonthlyChrunRate = $dateGroup->c_df_monthly_chrun_rate;
                            $dfMonthlyChrunRateMG = bcpow(bcadd(1, $dateGroup->c_df_monthly_chrun_rate_mg), $month);

                            $index = 0;
                            $deviceFinance = 0;
                            while ($count - $index >= 0 && $index <= 5) {
                                $d = Carbon::parse($date)->subMonths($index)->toDateString();
                                $coverage = bcmul($dateGroups[$d]->i_r_device_financing_cg, bcpow(bcadd(1, $dateGroups[$d]->i_r_device_financing_mg), $month));
                                $itemShipment = bcmul($dateGroups[$d]->i_shipment, $coverage);

                                $deviceFinance = bcadd($deviceFinance, bcmul($itemShipment, bcmul(bcmul($dfKimFee, $dfKimFeeMG), bcpow(bcadd(1, $dfMonthlyChrunRate), $index))));
                                $index++;
                            }
                            $dateGroup->i_r_device_financing = $deviceFinance;
                        }

                        // yearly preload
                        {
                            $yearlyPlacementFee = $dateGroup->c_yearly_placement_fee;
                            $yearlyPlacementFeeMG = bcpow(bcadd(1, $dateGroup->c_yearly_placement_fee_mg), $month);

                            $coverage = bcmul($dateGroup->i_yearly_app_preload_cg, bcpow(bcadd(1, $dateGroup->i_yearly_app_preload_mg), $month));

                            $dateGroup->i_yearly_app_preload = bcmul(1.2, bcmul($dateGroup->i_shipment, bcmul($yearlyPlacementFee, $yearlyPlacementFeeMG)));

                            $dateGroup->i_yearly_app_preload = bcmul($coverage, $dateGroup->i_yearly_app_preload);
                        }

                        $carrier_id = $projects[$dateGroup->project_id]->carrier_id;
                        $activatedShipment = bcmul($dateGroup->i_shipment, bcmul($dateGroup->c_activation_ratio, bcpow(bcadd(1, $dateGroup->c_activation_ratio_mg), $month)));

                        // (Revenue) Carrier Tab Fee
                        {
                            $carrierTabFeeCarrier = $dateGroup->c_carrier_tab_fee_carrier;
                            $carrierTabFeeCarrierMG = bcpow(bcadd(1, $dateGroup->c_carrier_tab_fee_carrier_mg), $month);
                            $carrierTabFeeOm = $dateGroup->c_carrier_tab_fee_om;
                            $carrierTabFeeOmMG = bcpow(bcadd(1, $dateGroup->c_carrier_tab_fee_om_mg), $month);
                            $coverage = bcmul($dateGroup->i_carrier_tab_fee_cg, bcpow(bcadd(1, $dateGroup->i_carrier_tab_fee_mg), $month));


                            if ($carrier_id == 0 || $carrier_id == $openMarket->id) {
                                $dateGroup->i_carrier_tab_fee = bcmul($activatedShipment, bcmul($carrierTabFeeOm, $carrierTabFeeOmMG));
                            } else {
                                $dateGroup->i_carrier_tab_fee = bcmul($activatedShipment, bcmul($carrierTabFeeCarrier, $carrierTabFeeCarrierMG));
                            }

                            $dateGroup->i_carrier_tab_fee = bcmul($coverage, $dateGroup->i_carrier_tab_fee);
                        }

                        {
                            $placementFeeCarrier = $dateGroup->c_placement_fee_carrier;
                            $placementFeeCarrierMG = bcpow(bcadd(1, $dateGroup->c_placement_fee_carrier_mg), $month);
                            $preloadAppActRateCarrier = $dateGroup->c_preload_app_act_rate_carrier;
                            $preloadAppActRateCarrierMG = bcpow(bcadd(1, $dateGroup->c_preload_app_act_rate_carrier_mg), $month);
                            $placementFeeOm = $dateGroup->c_placement_fee_om;
                            $placementFeeOmMG = bcpow(bcadd(1, $dateGroup->c_placement_fee_om_mg), $month);
                            $preloadAppActRateOm = $dateGroup->c_preload_app_act_rate_om;
                            $preloadAppActRateOmMG = bcpow(bcadd(1, $dateGroup->c_preload_app_act_rate_om_mg), $month);

                            $coverage = bcmul($dateGroup->i_app_preload_cg, bcpow(bcadd(1, $dateGroup->i_app_preload_mg), $month));

                            if ($carrier_id == 0 || $carrier_id == $openMarket->id) {
                                $dateGroup->i_app_preload = bcmul($activatedShipment, bcmul(bcmul($placementFeeOm, $placementFeeOmMG), bcmul($preloadAppActRateOm, $preloadAppActRateOmMG)));
                            } else {
                                $dateGroup->i_app_preload = bcmul($activatedShipment, bcmul(bcmul($placementFeeCarrier, $placementFeeCarrierMG), bcmul($preloadAppActRateCarrier, $preloadAppActRateCarrierMG)));
                            }

                            $dateGroup->i_app_preload = bcmul($coverage, $dateGroup->i_app_preload);
                        }

                        {
                            $adsOemRevShare = $dateGroup->c_ads_oem_rev_share;
                            $adsOemRevShareMG = bcpow(bcadd(1, $dateGroup->c_ads_oem_rev_share_mg), $month);
                            $adsCarrierRevShare = $dateGroup->c_ads_carrier_rev_share;
                            $adsCarrierRevShareMG = bcpow(bcadd(1, $dateGroup->c_ads_carrier_rev_share_mg), $month);
                            $adsAggregRevShare = $dateGroup->c_ads_aggreg_rev_share;
                            $adsAggregRevShareMG = bcpow(bcadd(1, $dateGroup->c_ads_aggreg_rev_share_mg), $month);
                            $adsAggregAppRatio = $dateGroup->c_ads_aggregator_app_ratio;
                            $adsAggregAppRatioMG = bcpow(bcadd(1, $dateGroup->c_ads_aggregator_app_ratio_mg), $month);
                            $adsAppDevRevShare = $dateGroup->c_ads_app_dev_or_content_provider_rev_share;
                            $adsAppDevRevShareMG = bcpow(bcadd(1, $dateGroup->c_ads_app_dev_or_content_provider_rev_share_mg), $month);
                            $adsKaiAppsRevenueRatio = $dateGroup->c_ads_kai_apps_ads_revenue_ratio;
                            $adsKaiAppsRevenueRatioMG = bcpow(bcadd(1, $dateGroup->c_ads_kai_apps_ads_revenue_ratio_mg), $month);

                            $coverage = bcmul($dateGroup->i_c_ads_revenue_sharing_cg, bcpow(bcadd(1, $dateGroup->i_c_ads_revenue_sharing_mg), $month));

                            $itemAdsRevenueSharing = $dateGroup->i_ads_revenue_sharing;
                            if ($dateGroup->market_id == $indiaMarket->id) {
                                $dateGroup->i_c_ads_revenue_sharing = bcmul(0.58, $itemAdsRevenueSharing);
                            } else {
                                $publisher = bcmul($itemAdsRevenueSharing, bcmul(bcsub(1, $adsKaiAppsRevenueRatio), $adsAppDevRevShare));
                                $aggregator = bcmul(bcsub($itemAdsRevenueSharing, $publisher), bcmul($adsAggregAppRatio, $adsAggregRevShare));
                                $carrier = bcmul(bcsub(bcsub($itemAdsRevenueSharing, $publisher), $aggregator), $adsCarrierRevShare);
                                $oem = bcmul(bcsub(bcsub(bcsub($itemAdsRevenueSharing, $publisher), $aggregator), $carrier), $adsOemRevShare);

                                $dateGroup->i_c_ads_revenue_sharing = bcadd(bcadd(bcadd($publisher, $aggregator), $carrier), $oem);

                            }
                        }

                        //fota cloud
                        {
                            $fotaCloud = $dateGroup->c_fota_cloud;
                            $fotaCloudMG = bcpow(bcadd(1, $dateGroup->c_fota_cloud_mg), $month);

                            $coverage = bcmul($dateGroup->i_fota_cloud_cg, bcpow(bcadd(1, $dateGroup->i_fota_cloud_mg), $month));


                            $dateGroup->i_fota_cloud = bcmul($activatedShipment, bcmul($fotaCloud, $fotaCloudMG));
                            $dateGroup->i_fota_cloud = bcmul($coverage, $dateGroup->i_fota_cloud);
                        }

                        //store cloud
                        {
                            $storeCloud = $dateGroup->c_store_cloud;
                            $storeCloudMG = bcpow(bcadd(1, $dateGroup->c_store_cloud_mg), $month);

                            $coverage = bcmul($dateGroup->i_store_cloud_cg, bcpow(bcadd(1, $dateGroup->i_store_cloud_mg), $month));
                            $dateGroup->i_store_cloud = bcmul($activatedShipment, bcmul($storeCloud, $storeCloudMG));
                            $dateGroup->i_store_cloud = bcmul($coverage, $dateGroup->i_store_cloud);
                        }

                        //push cloud
                        {
                            $pushCloud = $dateGroup->c_push_cloud;
                            $pushCloudMG = bcpow(bcadd(1, $dateGroup->c_push_cloud_mg), $month);

                            $coverage = bcmul($dateGroup->i_push_cloud_cg, bcpow(bcadd(1, $dateGroup->i_push_cloud_mg), $month));


                            $dateGroup->i_push_cloud = bcmul($activatedShipment, bcmul($pushCloud, $pushCloudMG));
                            $dateGroup->i_push_cloud = bcmul($coverage, $dateGroup->i_push_cloud);
                        }

                        {
                            //(Cost) PTU (SMS)
                            $ptuSMS = $dateGroup->c_ptu_sms;
                            $ptuSMSMG = bcpow(bcadd(1, $dateGroup->c_ptu_sms_mg), $month);

                            $coverage = bcmul($dateGroup->i_ptu_sms_cg, bcpow(bcadd(1, $dateGroup->i_ptu_sms_mg), $month));

                            $dateGroup->i_ptu_sms = bcmul($activatedShipment, bcmul($ptuSMS, $ptuSMSMG));

                            $dateGroup->i_ptu_sms = bcmul($coverage, $dateGroup->i_ptu_sms);
                        }

                        {
                            $touchpalLicensesCost = $dateGroup->c_touchpal_licenses_cost;
                            $touchpalLicensesCostMG = bcpow(bcadd(1, $dateGroup->c_touchpal_licenses_cost_mg), $month);

                            $coverage = bcmul($dateGroup->i_cost_3rd_party_licenses_cg, bcpow(bcadd(1, $dateGroup->i_cost_3rd_party_licenses_mg), $month));

                            $dateGroup->i_cost_3rd_party_licenses = bcmul($dateGroup->i_shipment, bcmul($touchpalLicensesCost, $touchpalLicensesCostMG));

                            $dateGroup->i_cost_3rd_party_licenses = bcmul($coverage, $dateGroup->i_cost_3rd_party_licenses);
                        }

                        // (Cost) Search revenue sharing
                        {
                            $revenueSharingCarrier = $dateGroup->c_srs_revenue_sharing_carrier;
                            $revenueSharingCarrierMG = bcpow(bcadd(1, $dateGroup->c_srs_revenue_sharing_carrier_mg), $month);
                            $revenueSharingOEM = $dateGroup->c_srs_revenue_sharing_oem;
                            $revenueSharingOEMMG = bcpow(bcadd(1, $dateGroup->c_srs_revenue_sharing_oem_mg), $month);

                            $coverage = bcmul($dateGroup->i_c_search_revenue_sharing_cg, bcpow(bcadd(1, $dateGroup->i_c_search_revenue_sharing_mg), $month));

                            $dateGroup->i_c_search_revenue_sharing = bcadd(bcmul($dateGroup->i_search_revenue_sharing, $revenueSharingCarrier), bcmul($revenueSharingOEM, bcsub($dateGroup->i_search_revenue_sharing, bcmul($dateGroup->i_search_revenue_sharing, $revenueSharingCarrier))));
                        }
//
                        // (Cost) Payment Revenue sharing
                        {

                            $prsAggregatorAppRatioStoreV1 = 0;
                            $prsAggregatorAppRatioStoreV2 = $dateGroup->c_prs_aggreg_app_ratio_v2;
                            $prsAggregatorAppRatioASPV2 = $dateGroup->c_prs_aggregator_app_ratio_iap;

                            $prsAggregRevShareStoreV1 = 0;
                            $prsAggregRevShareStoreV2 = $dateGroup->c_prs_aggreg_rev_share_v2;
                            $prsAggregRevShareASPV2 = $dateGroup->c_prs_aggrev_rev_share_iap;

                            $prsAppDevContentProviderRevShareStoreV1 = 0;
                            $prsAppDevContentProviderRevShareStoreV2 = $dateGroup->c_prs_app_dev_store_v2;
                            $prsAppDevContentProviderRevShareASPV2 = $dateGroup->c_prs_app_dev_or_content_provider_rev_share_iap;

                            $prsBillingCutStoreV1 = 0;
                            $prsBillingCutStoreV2 = $dateGroup->c_prs_billing_cut_store_v2;
                            $prsBillingCutASPV2 = $dateGroup->c_prs_billing_cut_iap;

                            $prsKaiAppsRevenueRatioStoreV1 = 0;
                            $prsKaiAppsRevenueRatioStoreV2 = $dateGroup->c_prs_kai_app_ratio_store_v2;
                            $prsKaiAppsRevenueRatioASPV2 = $dateGroup->c_prs_apps_payment_revenue_ratio_iap;

                            $prsCarrierRevShareStoreV1 = $dateGroup->c_prs_store_carrier_sharing_v1;
                            $prsCarrierRevShareStoreV2 = $dateGroup->c_prs_store_carrier_sharing_v2;
                            $prsCarrierRevShareASPV2 = $dateGroup->c_prs_carrier_sharing_iap;

                            $prsOemRevShareStoreV1 = $dateGroup->c_prs_store_oem_sharing_v1;
                            $prsOemRevShareStoreV2 = $dateGroup->c_prs_store_oem_sharing_v2;
                            $prsOemRevShareASPV2 = $dateGroup->c_prs_oem_sharing_iap;


                            $all = bcadd(bcadd($dateGroup->i_payments_revenue_sharing_iap, $dateGroup->i_payments_revenue_sharing_store_v2), $dateGroup->i_payments_revenue_sharing_store_v1);
                            $v1 = $dateGroup->i_payments_revenue_sharing_store_v1;
                            $v2 = $dateGroup->i_payments_revenue_sharing_store_v2;
                            $aspv2 = $dateGroup->i_payments_revenue_sharing_iap;
                            if ($dateGroup->market_id == $indiaMarket->id) {
                                $dateGroup->i_c_payment_revenue_sharing = bcmul(0.58, $all);
                            } else {
                                $billingStoreV1 = 0;
                                $billingStoreV2 = bcmul($v2, $prsBillingCutStoreV2);
                                $billingStoreV2 = $billingStoreV2 > 0? $billingStoreV2:0;
                                $billingAIPV2 = bcmul($aspv2, $prsBillingCutASPV2);
                                $billingAIPV2 = $billingAIPV2 > 0? $billingAIPV2:0;

                                $publisherStoreV1 = 0;
                                $publisherStoreV2 = bcmul(bcsub($v2, $billingStoreV2), bcmul(bcsub(1, $prsKaiAppsRevenueRatioStoreV2), $prsAppDevContentProviderRevShareStoreV2));
                                $publisherStoreV2  = $publisherStoreV2 > 0? $publisherStoreV2: 0;
                                $publisherAIPV2 = bcmul(bcsub($aspv2, $billingAIPV2), bcmul(bcsub(1, $prsKaiAppsRevenueRatioASPV2), $prsAppDevContentProviderRevShareASPV2));
                                $publisherAIPV2  = $publisherAIPV2 > 0? $publisherAIPV2: 0;

                                $aggregatorStoreV1 = 0;
                                $aggregatorStoreV2 = bcmul(bcsub(bcsub($v2, $billingStoreV2), $publisherStoreV2), bcmul($prsAggregatorAppRatioStoreV2, $prsAggregRevShareStoreV2));
                                $aggregatorStoreV2  = $aggregatorStoreV2 > 0? $aggregatorStoreV2: 0;
                                $aggregatorAIPV2 = bcmul(bcsub(bcsub($aspv2, $billingAIPV2), $publisherAIPV2), bcmul($prsAggregatorAppRatioASPV2, $prsAggregRevShareASPV2));
                                $aggregatorAIPV2  = $aggregatorAIPV2 > 0? $aggregatorAIPV2: 0;

                                $carrierStoreV1 = bcmul($v1, $prsCarrierRevShareStoreV1);
                                $carrierStoreV1  = $carrierStoreV1 > 0? $carrierStoreV1: 0;
                                $carrierStoreV2 = bcmul(bcsub(bcsub(bcsub($v2, $billingStoreV2), $aggregatorStoreV2), $publisherStoreV2), $prsCarrierRevShareStoreV2);
                                $carrierStoreV2  = $carrierStoreV2 > 0? $carrierStoreV2: 0;
                                $carrierAIPV2 = bcmul(bcsub(bcsub(bcsub($aspv2, $billingAIPV2), $aggregatorAIPV2), $publisherAIPV2), $prsCarrierRevShareASPV2);
                                $carrierAIPV2  = $carrierAIPV2 > 0? $carrierAIPV2: 0;

                                $oemStoreV1 = bcmul(bcsub($v1, $carrierStoreV1), $prsOemRevShareStoreV1);
                                $oemStoreV1  = $oemStoreV1 > 0? $oemStoreV1: 0;
                                $oemStoreV2 = bcmul(bcsub(bcsub(bcsub(bcsub($v2, $carrierStoreV2), $aggregatorStoreV2), $publisherStoreV2), $billingStoreV2), $prsOemRevShareStoreV2);
                                $oemStoreV2  = $oemStoreV2 > 0? $oemStoreV2: 0;
                                $oemAIPV2 = bcmul(bcsub(bcsub(bcsub(bcsub($aspv2, $carrierAIPV2), $aggregatorAIPV2), $publisherAIPV2), $billingAIPV2), $prsOemRevShareASPV2);
                                $oemAIPV2  = $oemAIPV2 > 0? $oemAIPV2: 0;

                                $storeV1 = bcadd(bcadd(bcadd(bcadd($publisherStoreV1, $aggregatorStoreV1), $carrierStoreV1), $oemStoreV1), $billingStoreV1);
                                $storeV1  = $storeV1 > 0? $storeV1: 0;
                                $storeV2 = bcadd(bcadd(bcadd(bcadd($publisherStoreV2, $aggregatorStoreV2), $carrierStoreV2), $oemStoreV2), $billingStoreV2);
                                $storeV2  = $storeV2 > 0? $storeV2: 0;
                                $ASPV2 = bcadd(bcadd(bcadd(bcadd($publisherAIPV2, $aggregatorAIPV2), $carrierAIPV2), $oemAIPV2), $billingAIPV2);
                                $ASPV2 = $ASPV2 > 0? $ASPV2: 0;
                                if (($dateGroup->project_id == 62 || $dateGroup->project_id == 90) && ($date == '2020-06-01')) {


                                    Log::info('StoreV1-' . $v1);
                                    Log::info('StoreV2-' . $v2);
                                    Log::info('ASPV2-' . $aspv2);
                                    Log::info('Date-' . $date);

                                    Log::info('BillingStoreV1-' . $billingStoreV1);
                                    Log::info('BillingStoreV2-' . $billingStoreV2);
                                    Log::info('BillingASPV2-' . $billingAIPV2);
                                    Log::info('PublisherStoreV1-' . $publisherStoreV1);
                                    Log::info('PublisherStoreV2-' . $publisherStoreV2);
                                    Log::info('PublisherASPV2-' . $publisherAIPV2);
                                    Log::info('AggregatorStoreV1-' . $aggregatorStoreV1);
                                    Log::info('AggregatorStoreV2-' . $aggregatorStoreV2);
                                    Log::info('AggregatorASPV1-' . $aggregatorAIPV2);
                                    Log::info('CarrierStoreV1-' . $carrierStoreV1);
                                    Log::info('CarrierStoreV2-' . $carrierStoreV2);
                                    Log::info('CarrierASPV2-' . $carrierAIPV2);
                                    Log::info('OEMStoreV1-' . $oemStoreV1);
                                    Log::info('OEMStoreV2-' . $oemStoreV2);
                                    Log::info('OEMASPV2-' . $oemAIPV2);
                                }


                                $dateGroup->i_c_payment_revenue_sharing = bcadd(bcadd($storeV1, $storeV2), $ASPV2);
                                $dateGroup->i_c_payment_revenue_sharing = $dateGroup->i_c_payment_revenue_sharing > 0 ? $dateGroup->i_c_payment_revenue_sharing: 0;

                            }
                        }


                        $dateGroup->save();

                        array_push($insertData, [
                            'model_id' => $modelId,
                            'model_vid' => $modelVid,
                            'location_id' => $dateGroup->location_id,
                            'project_id' => $dateGroup->project_id,
                            'date' => $date,
                            'item_id' => I_SHIPMENT,
                            'result' => $dateGroup->i_shipment,
                        ]);
//
                        array_push($insertData, [
                            'model_id' => $modelId,
                            'model_vid' => $modelVid,
                            'location_id' => $dateGroup->location_id,
                            'project_id' => $dateGroup->project_id,
                            'date' => $date,
                            'item_id' => I_INSTALL_BASE,
                            'result' => $dateGroup->i_install_base,
                        ]);

                        array_push($insertData, [
                            'model_id' => $modelId,
                            'model_vid' => $modelVid,
                            'location_id' => $dateGroup->location_id,
                            'project_id' => $dateGroup->project_id,
                            'date' => $date,
                            'item_id' => I_ACTIVATED_DEVICE,
                            'result' => $dateGroup->i_activated_device,
                        ]);

                        array_push($insertData, [
                            'model_id' => $modelId,
                            'model_vid' => $modelVid,
                            'location_id' => $dateGroup->location_id,
                            'project_id' => $dateGroup->project_id,
                            'date' => $date,
                            'item_id' => I_MAU,
                            'result' => $dateGroup->i_mau,
                        ]);

                        array_push($insertData, [
                            'model_id' => $modelId,
                            'model_vid' => $modelVid,
                            'location_id' => $dateGroup->location_id,
                            'project_id' => $dateGroup->project_id,
                            'date' => $date,
                            'item_id' => I_ADS_MAU,
                            'result' => $dateGroup->i_ads_dau,
                        ]);

                        array_push($insertData, [
                            'model_id' => $modelId,
                            'model_vid' => $modelVid,
                            'location_id' => $dateGroup->location_id,
                            'project_id' => $dateGroup->project_id,
                            'date' => $date,
                            'item_id' => I_FOTA_FEE,
                            'result' => $dateGroup->i_fota_fee,
                        ]);

                        array_push($insertData, [
                            'model_id' => $modelId,
                            'model_vid' => $modelVid,
                            'location_id' => $dateGroup->location_id,
                            'project_id' => $dateGroup->project_id,
                            'date' => $date,
                            'item_id' => I_FOTA_ROYALTY,
                            'result' => $dateGroup->i_fota_royalty,
                        ]);

                        array_push($insertData, [
                            'model_id' => $modelId,
                            'model_vid' => $modelVid,
                            'location_id' => $dateGroup->location_id,
                            'project_id' => $dateGroup->project_id,
                            'date' => $date,
                            'item_id' => I_SEARCH_REVENUE_SHARING,
                            'result' => $dateGroup->i_search_revenue_sharing,
                        ]);

                        array_push($insertData, [
                            'model_id' => $modelId,
                            'model_vid' => $modelVid,
                            'location_id' => $dateGroup->location_id,
                            'project_id' => $dateGroup->project_id,
                            'date' => $date,
                            'item_id' => I_ADS_REVENUE_SHARING,
                            'result' => $dateGroup->i_ads_revenue_sharing,
                        ]);

                        array_push($insertData, [
                            'model_id' => $modelId,
                            'model_vid' => $modelVid,
                            'location_id' => $dateGroup->location_id,
                            'project_id' => $dateGroup->project_id,
                            'date' => $date,
                            'item_id' => I_NRE,
                            'result' => $dateGroup->i_nre,
                        ]);

                        array_push($insertData, [
                            'model_id' => $modelId,
                            'model_vid' => $modelVid,
                            'location_id' => $dateGroup->location_id,
                            'project_id' => $dateGroup->project_id,
                            'date' => $date,
                            'item_id' => I_MAINTENANCE,
                            'result' => $dateGroup->i_maintenance,
                        ]);

                        array_push($insertData, [
                            'model_id' => $modelId,
                            'model_vid' => $modelVid,
                            'location_id' => $dateGroup->location_id,
                            'project_id' => $dateGroup->project_id,
                            'date' => $date,
                            'item_id' => I_PAYMENTS_REVENUE_SHARING_STORE_V1,
                            'result' => $dateGroup->i_payments_revenue_sharing_store_v1,
                        ]);

                        array_push($insertData, [
                            'model_id' => $modelId,
                            'model_vid' => $modelVid,
                            'location_id' => $dateGroup->location_id,
                            'project_id' => $dateGroup->project_id,
                            'date' => $date,
                            'item_id' => I_PAYMENTS_REVENUE_SHARING_STORE_V2,
                            'result' => $dateGroup->i_payments_revenue_sharing_store_v2,
                        ]);

                        array_push($insertData, [
                            'model_id' => $modelId,
                            'model_vid' => $modelVid,
                            'location_id' => $dateGroup->location_id,
                            'project_id' => $dateGroup->project_id,
                            'date' => $date,
                            'item_id' => I_PAYMENTS_REVENUE_SHARING_IAP_V2,
                            'result' => $dateGroup->i_payments_revenue_sharing_iap,
                        ]);

                        array_push($insertData, [
                            'model_id' => $modelId,
                            'model_vid' => $modelVid,
                            'location_id' => $dateGroup->location_id,
                            'project_id' => $dateGroup->project_id,
                            'date' => $date,
                            'item_id' => I_REVENUE_3RD_PARTY_LICENSES,
                            'result' => $dateGroup->i_revenue_3rd_party_licenses,
                        ]);

                        array_push($insertData, [
                            'model_id' => $modelId,
                            'model_vid' => $modelVid,
                            'location_id' => $dateGroup->location_id,
                            'project_id' => $dateGroup->project_id,
                            'date' => $date,
                            'item_id' => I_YEARLY_APP_PRELOAD,
                            'result' => $dateGroup->i_yearly_app_preload,
                        ]);

                        array_push($insertData, [
                            'model_id' => $modelId,
                            'model_vid' => $modelVid,
                            'location_id' => $dateGroup->location_id,
                            'project_id' => $dateGroup->project_id,
                            'date' => $date,
                            'item_id' => I_CARRIER_TAB_FEE,
                            'result' => $dateGroup->i_carrier_tab_fee,
                        ]);

                        array_push($insertData, [
                            'model_id' => $modelId,
                            'model_vid' => $modelVid,
                            'location_id' => $dateGroup->location_id,
                            'project_id' => $dateGroup->project_id,
                            'date' => $date,
                            'item_id' => I_APP_PRELOAD,
                            'result' => $dateGroup->i_app_preload,
                        ]);

                        array_push($insertData, [
                            'model_id' => $modelId,
                            'model_vid' => $modelVid,
                            'location_id' => $dateGroup->location_id,
                            'project_id' => $dateGroup->project_id,
                            'date' => $date,
                            'item_id' => I_COST_ADS_REVENUE_SHARING,
                            'result' => $dateGroup->i_c_ads_revenue_sharing,
                        ]);

                        array_push($insertData, [
                            'model_id' => $modelId,
                            'model_vid' => $modelVid,
                            'location_id' => $dateGroup->location_id,
                            'project_id' => $dateGroup->project_id,
                            'date' => $date,
                            'item_id' => I_FOTA_CLOUD,
                            'result' => $dateGroup->i_fota_cloud,
                        ]);

                        array_push($insertData, [
                            'model_id' => $modelId,
                            'model_vid' => $modelVid,
                            'location_id' => $dateGroup->location_id,
                            'project_id' => $dateGroup->project_id,
                            'date' => $date,
                            'item_id' => I_STORE_CLOUD,
                            'result' => $dateGroup->i_store_cloud,
                        ]);

                        array_push($insertData, [
                            'model_id' => $modelId,
                            'model_vid' => $modelVid,
                            'location_id' => $dateGroup->location_id,
                            'project_id' => $dateGroup->project_id,
                            'date' => $date,
                            'item_id' => I_PUSH_CLOUD,
                            'result' => $dateGroup->i_push_cloud,
                        ]);

                        array_push($insertData, [
                            'model_id' => $modelId,
                            'model_vid' => $modelVid,
                            'location_id' => $dateGroup->location_id,
                            'project_id' => $dateGroup->project_id,
                            'date' => $date,
                            'item_id' => I_COST_3RD_PARTY_LICENSES,
                            'result' => $dateGroup->i_cost_3rd_party_licenses,
                        ]);

                        array_push($insertData, [
                            'model_id' => $modelId,
                            'model_vid' => $modelVid,
                            'location_id' => $dateGroup->location_id,
                            'project_id' => $dateGroup->project_id,
                            'date' => $date,
                            'item_id' => I_FTU_SMS,
                            'result' => $dateGroup->i_ptu_sms,
                        ]);

                        array_push($insertData, [
                            'model_id' => $modelId,
                            'model_vid' => $modelVid,
                            'location_id' => $dateGroup->location_id,
                            'project_id' => $dateGroup->project_id,
                            'date' => $date,
                            'item_id' => I_R_DEVICE_FINANCING,
                            'result' => $dateGroup->i_r_device_financing,
                        ]);

                        array_push($insertData, [
                            'model_id' => $modelId,
                            'model_vid' => $modelVid,
                            'location_id' => $dateGroup->location_id,
                            'project_id' => $dateGroup->project_id,
                            'date' => $date,
                            'item_id' => I_COST_SEARCH_REVENUE_SHARING,
                            'result' => $dateGroup->i_c_search_revenue_sharing,
                        ]);

                        array_push($insertData, [
                            'model_id' => $modelId,
                            'model_vid' => $modelVid,
                            'location_id' => $dateGroup->location_id,
                            'project_id' => $dateGroup->project_id,
                            'date' => $date,
                            'item_id' => I_COST_PAYMENT_REVENUE_SHARING,
                            'result' => $dateGroup->i_c_payment_revenue_sharing,
                        ]);


                        if (count($insertData) > BULK_NUMBER) {
                            ModelResult::insert($insertData);
                            $insertData = [];
                        }

                        $count++;
                        $prevDateGroup = $dateGroup;
                    }
                }
            }

            if ($insertData) {
                ModelResult::insert($insertData);
            }

        }

}
