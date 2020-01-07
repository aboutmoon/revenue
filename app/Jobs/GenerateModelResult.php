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
            $project_ids = Project::where(function($q1) use ($forecastItem) {
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
                    case I_REVENUE_3RD_PARTY_LICENSES:
                        $updateData['i_revenue_3rd_licenses_mg'] = $forecastItem->monthly_growth;
                        $updateData['i_revenue_3rd_licenses_cg'] = $forecastItem->coverage;
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
                    default:
                        break;
                }

                DB::table('forecast_devices_view')
                    ->where('model_id', $modelId)
                    ->where('model_vid', $modelVid)
                    ->where(function($q1) use($market_ids, $project_ids, $forecastItem){
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
            $project_ids = Project::where(function($q1) use ($forecastCriteria) {
                if ($forecastCriteria->oem_id) {
                    $q1->where('oem_id', $forecastCriteria->oem_id);
                }
                if ($forecastCriteria->odm_id) {
                    $q1->where('odm_id', $forecastCriteria->odm_id);
                }
                if ($forecastCriteria->carrier_id) {
                    $q1->where('carrier_id', $forecastCriteria->carrier_id);
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
            $locationGroups[$forecastDeviceView->location_id][$forecastDeviceView->project_id][$forecastDeviceView->date]=$forecastDeviceView;
        }

        $insertData = [];
        foreach ($locationGroups as $projectGroups) {
            foreach ($projectGroups as $dateGroups) {
                $count = 0;
                $prevDateGroup = null;
                foreach ($dateGroups as $date => $dateGroup) {
                    bcscale(15);

                    $month = Carbon::parse($date)->month - 1;

                    //install base

                    {
                        $chrun_rate = bcmul($dateGroup->c_chrun_rate, pow(bcadd(1, $dateGroup->c_chrun_rate_mg), $month));
                        $coverage = bcmul($dateGroup->i_install_base_cg, pow(bcadd(1, $dateGroup->i_install_base_mg), $month));
                        $lifetime = $dateGroup->c_lifetime;

                        if ($count == 0) {

                            $dateGroup->i_install_base = $dateGroup->i_shipment;

                        } elseif ($count <= $lifetime) {

                            $dateGroup->i_install_base = bcadd(bcmul($prevDateGroup->i_install_base, bcsub(1, $chrun_rate)), $dateGroup->i_shipment);

                        } elseif ($count > $lifetime) {

                            $d = Carbon::parse($date)->subMonths($lifetime)->toDateString();
                            $shipment = $dateGroups[$d]? $dateGroups[$d]->i_shipment: 0;

                            $result = bcsub(bcadd(bcmul($prevDateGroup->i_install_base, bcsub(1, $chrun_rate)), $dateGroup->i_shipment), $shipment);
                            $dateGroup->i_install_base = $result > 0 ? $result: 0;
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
                        $coverage = bcmul($dateGroup->i_activated_device_cg, pow(bcadd(1, $dateGroup->i_activated_device_mg), $month));
                    }
                    $dateGroup->i_activated_device =  bcmul(bcmul($installBase, $activationRatio), $activationRatioMG) ;

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

                    $dateGroup->i_mau = bccomp($mauHelper, $dateGroup->i_install_base) > 0 ? $dateGroup->i_install_base: $mauHelper;
                    $dateGroup->i_mau = bcmul($dateGroup->i_mau, $coverage);

                    // ads dau
                    $adsDauFromMau = $dateGroup->c_ads_dau_from_mau;
                    $adsDauFromMauMG = pow(bcadd(1, $dateGroup->c_ads_dau_from_mau_mg), $month);
                    $coverage = bcmul($dateGroup->i_ads_dau_cg, pow(bcadd(1, $dateGroup->i_ads_dau_mg), $month));
                    $dateGroup->i_ads_dau = bcmul(bcmul(bcmul($dateGroup->i_mau, $adsDauFromMau), $adsDauFromMauMG), $dateGroup->i_ads_revenue_sharing_cg);
                    $dateGroup->i_ads_dau = bcmul($dateGroup->i_ads_dau, $coverage);

                    // fota fee
                    $fotaFee = $dateGroup->c_fota_fee;
                    $fotaFeeMG = pow(bcadd(1, $dateGroup->c_fota_fee_mg), $month);
                    $coverage = bcmul($dateGroup->i_fota_fee_cg, pow(bcadd(1, $dateGroup->i_fota_fee_mg), $month));

                    $dateGroup->i_fota_fee = bcmul(bcmul($dateGroup->i_shipment, $fotaFee), $fotaFeeMG);
                    $dateGroup->i_fota_fee = bcmul($dateGroup->i_fota_fee, $coverage);

                    $fotaRoyaltyFee = $dateGroup->c_fota_royalty_fee;
                    $fotaRoyaltyFeeMG = pow(bcadd(1, $dateGroup->c_fota_royalty_fee_mg), $month);
                    $coverage = bcmul($dateGroup->i_fota_royalty_cg, pow(bcadd(1, $dateGroup->i_fota_royalty_mg), $month));
                    $dateGroup->i_fota_royalty = bcmul(bcmul($dateGroup->i_shipment, $fotaRoyaltyFee), $fotaRoyaltyFeeMG);
                    $dateGroup->i_fota_royalty = bcmul($dateGroup->i_fota_royalty, $coverage);



                    // search revenue sharing
                    $searchRevenuePer1KMau = $dateGroup->c_search_revenue_per_1k_mau;
                    $searchRevenuePer1KMauMG = pow(bcadd(1, $dateGroup->c_search_revenue_per_1k_mau_mg), $month);
                    $coverage = bcmul($dateGroup->i_search_revenue_sharing_cg, pow(bcadd(1, $dateGroup->i_search_revenue_sharing_mg), $month));
                    $dateGroup->i_search_revenue_sharing = bcdiv(bcmul(bcmul($dateGroup->i_mau, $searchRevenuePer1KMau), $searchRevenuePer1KMauMG), 1000);
                    $dateGroup->i_search_revenue_sharing = bcmul($dateGroup->i_search_revenue_sharing, $coverage);

                    // ads revenue sharing
                    $adsRevenuePer1KAdsDau = $dateGroup->c_ads_revenue_per_1k_ads_dau;
                    $adsRevenuePer1KAdsDauMG = pow(bcadd($dateGroup->c_ads_revenue_per_1k_ads_dau_mg, 1), $month);
                    $adsMonthlyPageView = $dateGroup->c_ads_monthly_page_view;
                    $adsMonthlyPageViewMG = pow(bcadd($dateGroup->c_ads_monthly_page_view_mg, 1), $month);
                    $adsEcpm = $dateGroup->c_ads_ecpm;
                    $adsEcpmMG = pow(bcadd($dateGroup->c_ads_ecpm_mg, 1), $month);
                    $coverage = bcmul($dateGroup->i_ads_revenue_sharing_cg, pow(bcadd($dateGroup->i_ads_revenue_sharing_mg, 1), $month));
                    $dateGroup->i_ads_revenue_sharing = bcadd(bcdiv(bcmul(bcmul(bcmul(bcmul($dateGroup->i_mau, $adsMonthlyPageView), $adsMonthlyPageViewMG), $adsEcpm), $adsEcpmMG), 1000), bcdiv(bcmul(bcmul(bcmul($dateGroup->i_ads_dau, $adsRevenuePer1KAdsDau), $adsRevenuePer1KAdsDauMG), 30), 1000));
                    $dateGroup->i_ads_revenue_sharing = bcmul($dateGroup->i_ads_revenue_sharing, $coverage);


                    // nre
                    $monthlyTeamPrice = $dateGroup->c_monthly_team_price;
                    $monthlyTeamPriceMG = pow(bcadd($dateGroup->c_monthly_team_price_mg, 1), $month);
                    $coverage = bcmul($dateGroup->i_nre_cg, pow(bcadd(1, $dateGroup->i_nre_mg), $month));

                    $dateGroup->i_nre = bcmul($monthlyTeamPrice, $monthlyTeamPriceMG);
                    $dateGroup->i_nre = bcmul($dateGroup->i_nre, $coverage);

                    // maintenance
                    $yearlyMaintenancePrice = $dateGroup->c_yearly_maintenance_price;
                    $yearlyMaintenancePriceMG = bcpow(bcadd(1, $dateGroup->c_yearly_maintenance_price_mg), $month);
                    $coverage = bcmul($dateGroup->i_maintenance_cg, pow(bcadd(1, $dateGroup->i_maintenance_mg), $month));

                    $dateGroup->i_maintenance = bcdiv(bcmul($yearlyMaintenancePrice, $yearlyMaintenancePriceMG), 12);
                    $dateGroup->i_maintenance = bcmul($dateGroup->i_maintenance, $coverage);

                    //

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
