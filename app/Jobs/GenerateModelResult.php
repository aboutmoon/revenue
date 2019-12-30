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
const I_INSTALL_BASE = 3;
const I_ACTIVATED_DEVICE = 4;
const I_MAU = 5;
const I_ADS_MAU = 6;
const I_FOTA_FEE = 8;
const I_SEARCH_REVENUE_SHARING = 10;
const I_ADS_REVENUE_SHARING = 11;


const C_SHIPMENT = 1;

const C_CHURN_RATE = 2;
const C_DEVICE_LIFETIME = 3;

const C_ACTIVATION_RATIO = 4;

const C_INITIAL_MAU_RATIO = 5;
const C_MAU_GROWTH_FACTOR = 6;

const C_ADS_DAU_FROM_MAU = 7;

const C_FOTA_FEE = 8;

const C_SEARCH_REVENUE_PER_1K_MAU = 10;

const C_MONTHLY_PAGE_VIEW = 11;
const C_ECPM = 12;
const C_ADS_REVENUE_PER_1K_ADS_DAU = 13;

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
            })->pluck('id')->toArray();
            foreach ($forecastItem->items as $item) {
                $item_id = $item->id;
                $updateData = [];

                switch ($item_id) {
                    case I_SHIPMENT:
                        $updateData['i_shipment_mg'] = $forecastItem->monthly_growth;break;
                    case I_INSTALL_BASE:
                        $updateData['i_install_base_mg'] = $forecastItem->monthly_growth;break;
                    case I_ACTIVATED_DEVICE:
                        $updateData['i_activated_device_mg'] = $forecastItem->monthly_growth;break;
                    case I_MAU:
                        $updateData['i_mau_mg'] = $forecastItem->monthly_growth;break;
                    case  I_ADS_MAU:
                        $updateData['i_ads_mau'] = $forecastItem->monthly_growth;break;
                    case I_FOTA_FEE:
                        $updateData['i_fota_fee'] = $forecastItem->monthly_growth;break;
                    case I_SEARCH_REVENUE_SHARING:
                        $updateData['i_search_revenue_sharing'] = $forecastItem->monthly_growth;break;
                    case I_ADS_REVENUE_SHARING:
                        $updateData['i_ads_revenue_sharing'] = $forecastItem->monthly_growth;break;
                    default:
                        throwExceptionOnError('Error Item');
                }

                DB::table('forecast_devices_view')
                    ->where('model_id', $modelId)
                    ->where('model_vid', $modelVid)
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
//                    $updateData['c_shipment'] = $parameter->value;
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

                if ($item_id == I_ADS_REVENUE_SHARING) {
                    if ($parameter->criteria_id == C_MONTHLY_PAGE_VIEW) {
                        $updateData['c_monthly_page_view'] = $parameter->value;
                        $updateData['c_monthly_page_view_mg'] = $parameter->monthly_growth;
                    }
                    if ($parameter->criteria_id == C_ADS_REVENUE_PER_1K_ADS_DAU) {
                        $updateData['c_ads_revenue_per_1k_ads_dau'] = $parameter->value;
                        $updateData['c_ads_revenue_per_1k_ads_dau_mg'] = $parameter->monthly_growth;
                    }
                    if ($parameter->criteria_id == C_ECPM) {
                        $updateData['c_ecpm'] = $parameter->value;
                        $updateData['c_ecpm_mg'] = $parameter->monthly_growth;
                    }
                }

                if ($item_id == I_SEARCH_REVENUE_SHARING) {
                    if ($parameter->criteria_id == C_SEARCH_REVENUE_PER_1K_MAU) {
                        $updateData['c_search_revenue_per_1k_mau'] = $parameter->value;
                        $updateData['c_search_revenue_per_1k_mau_mg'] = $parameter->monthly_growth;
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
                    //install base
                    $lifetime = $dateGroup->c_lifetime;

                    if ($count == 0) {

                        $dateGroup->i_install_base = $dateGroup->i_shipment;

                    } elseif ($count <= $lifetime) {

//                        $dateGroup->i_install_base = $prevDateGroup->i_install_base * (1 - $dateGroup->c_chrun_rate) + $dateGroup->i_shipment;
                        $dateGroup->i_install_base = bcadd(bcmul($prevDateGroup->i_install_base, bcsub(1, $dateGroup->c_chrun_rate)), $dateGroup->i_shipment);

                    } elseif ($count > $lifetime) {

                        $d = Carbon::parse($date)->subMonths($lifetime)->toDateString();
                        $shipment = $dateGroups[$d]? $dateGroups[$d]->i_shipment: 0;

//                        $result = $prevDateGroup->i_install_base * (1 - $dateGroup->c_chrun_rate) + $dateGroup->i_shipment - $shipment;
                        $result = bcsub(bcadd(bcmul($prevDateGroup->i_install_base, bcsub(1, $dateGroup->c_chrun_rate)), $dateGroup->i_shipment), $shipment);
                        $dateGroup->i_install_base = $result > 0 ? $result: 0;
                    }

                    // activated device
                    $month = Carbon::parse($date)->month - 1;
//                    $dateGroup->i_activated_device =  $dateGroup->i_install_base * $dateGroup->c_activation_ratio * pow(1 + $dateGroup->c_activation_ratio_mg, $month);
                    $dateGroup->i_activated_device =  bcmul(bcmul($dateGroup->i_install_base, $dateGroup->c_activation_ratio), bcpow(1 + $dateGroup->c_activation_ratio_mg, $month)) ;

                    if ($count == 0 || bccomp($prevDateGroup->i_activated_device, 0) == 0) {
                        $mauHelper = bcmul($dateGroup->i_activated_device, $dateGroup->c_mau_growth_factor);
                    } else {
                        $month = Carbon::parse($date)->month - 1;
                        $year = Carbon::parse($date)->year;
                        $activatedDeviceDiff = bcsub($dateGroup->i_activated_device, $prevDateGroup->i_activated_device);

                        if (bccomp($activatedDeviceDiff, 0) >= 0 && $year == 2020) {
                            $mauHelper = bcadd(bcmul($prevDateGroup->i_activated_device, $dateGroup->c_mau_growth_factor), bcmul(bcpow(bcadd(1, $dateGroup->c_mau_growth_factor_mg), $month), bcmul($activatedDeviceDiff, $dateGroup->c_mau_growth_factor)));
                        } else {
                            $mauHelper = bcadd(bcmul($prevDateGroup->i_activated_device, $dateGroup->c_mau_growth_factor), bcmul($activatedDeviceDiff, $dateGroup->c_mau_growth_factor));
                        }
                    }

                    $dateGroup->i_mau = bccomp($mauHelper, $dateGroup->i_install_base) > 0 ? $dateGroup->i_install_base: $mauHelper;

                    // ads mau
                    $month = Carbon::parse($date)->month - 1;
                    $dateGroup->i_ads_mau = bcmul(bcmul($dateGroup->i_mau, $dateGroup->c_ads_dau_from_mau), bcpow(bcadd(1, $dateGroup->c_ads_dau_from_mau_mg), $month, 9));
                    $dateGroup->save();

                    // fota fee
                    $dateGroup->i_fota_fee = bcmul($dateGroup->i_shipment, $dateGroup->c_fota_fee);

                    // search revenue sharing
                    $dateGroup->i_search_revenue_sharing = bcmul($dateGroup->i_mau, $dateGroup->c_search_revenue_per_1k_mau);

                    // ads revenue sharing
                    $dateGroup->i_ads_revenue_sharing = bcadd(bcmul(bcdiv(bcmul($dateGroup->ads_revenue_per_1k_ads_dau, $dateGroup->i_ads_dau), 1000), 30), bcdiv(bcmul(bcmul($dateGroup->i_mau, $dateGroup->c_monthly_page_view), $dateGroup->c_ecpm), 1000));

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
                        'result' => $dateGroup->i_ads_mau,
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

        //
    }


//    // expand criteria
//$this->expandForecastCriterias($modelId, $modelVid);
//
//    // expand items
//$this->expandForecastItem($modelId, $modelVid);
//
//    // remove results.
//DB::table('model_results')->where('model_id', $modelId)->where('model_vid', $modelVid)->delete();
//
//    // shipment calculation
////        $this->forecastCaculate($modelId, $modelVid, 2);
//
//$this->installBaseCalculate($modelId, $modelVid, 3);
//
//$this->activeDeviceCalculate($modelId, $modelVid, 4);
//
//$this->mAUCaculate($modelId, $modelVid, 5);

    public function activeDeviceCalculate($model_id, $model_vid, $item_id) {
        $itemInstallBase = 3;
        $installBases = DB::table('forecast_devices')->select(
            'forecast_devices.location_id',
            'forecast_devices.project_id',
            'forecast_devices.date',
            'forecast_devices.quantity',
            'forecast_items_view.item_id',
            'forecast_items_view.coverage',
            'forecast_items_view.date_from',
            'forecast_criterias_view.criteria_id',
            'forecast_criterias_view.value',
            'model_results.result')
            ->join('forecast_items_view', function ($join) use ($model_id, $model_vid, $item_id) {
                $join->on('forecast_devices.market_id', '=', 'forecast_items_view.location_id')
                    ->on('forecast_devices.project_id', '=', 'forecast_items_view.project_id')
                    ->on('forecast_devices.date', '=', 'forecast_items_view.date')
                    ->where('forecast_items_view.model_id', $model_id)
                    ->where('forecast_items_view.model_vid', $model_vid)
                    ->where('forecast_items_view.item_id', $item_id);
            })->join('model_results', function ($join) use ($model_id, $model_vid, $itemInstallBase) {
                $join->on('forecast_devices.location_id', '=', 'model_results.location_id')
                    ->on('forecast_devices.project_id', '=', 'model_results.project_id')
                    ->on('forecast_devices.date', '=', 'model_results.date')
                    ->where('model_results.model_id', $model_id)
                    ->where('model_results.model_vid', $model_vid)
                    ->where('model_results.item_id', $itemInstallBase);
            })->join('forecast_criterias_view', function($join) use ($model_id, $model_vid, $item_id) {
                $join->on('forecast_devices.market_id', '=', 'forecast_criterias_view.location_id')
                    ->on('forecast_devices.project_id', '=', 'forecast_criterias_view.project_id')
                    ->on('forecast_devices.date', '=', 'forecast_criterias_view.date')
                    ->where('forecast_criterias_view.model_id', $model_id)
                    ->where('forecast_criterias_view.model_vid', $model_vid)
                    ->where('forecast_criterias_view.item_id', $item_id);
            })->get();

        $container = [];
        foreach ($installBases as $result) {
            if (isset($container[$result->location_id][$result->project_id][$result->date])) {
                $container[$result->location_id][$result->project_id][$result->date][$result->criteria_id]=$result;
            } else {
                $container[$result->location_id][$result->project_id][$result->date][$result->criteria_id]=$result;
            }
        }

        $insertData = [];
        foreach ($container as $location) {


            foreach ($location as $project) {
                foreach ($project as $date) {
                    $activeRatio = (double)$date[4]->value;
                    $base = $date[4];
                    $installBase = (double)$base->result;
                    $data = [
                        'model_id' => $model_id,
                        'model_vid' => $model_vid,
                        'item_id' => $base->item_id,
                        'location_id' => $base->location_id,
                        'project_id' => $base->project_id,
                        'date' => $base->date
                    ];
                    $data['result'] = $installBase * $activeRatio;
                    array_push($insertData, $data);
                }
            }
            if (count($insertData) > 7000) {
                ModelResult::insert($insertData);
                $insertData = [];
            }
        }

        if ($insertData) {
            ModelResult::insert($insertData);
        }

    }

    public function forecastCaculate($model_id, $model_vid, $item_id) {
        $results = DB::table('forecast_devices')
            ->select(
            'forecast_devices.location_id',
                    'forecast_devices.project_id',
                    'forecast_devices.date',
                    'forecast_items_view.item_id',
                    'forecast_criterias_view.value'
                )
            ->join('forecast_items_view', function ($join) use ($model_id, $model_vid, $item_id) {
            $join->on('forecast_devices.market_id', '=', 'forecast_items_view.location_id')
            ->on('forecast_devices.project_id', '=', 'forecast_items_view.project_id')
            ->on('forecast_devices.date', '=', 'forecast_items_view.date')
                ->where('forecast_items_view.model_id', $model_id)
                ->where('forecast_items_view.model_vid', $model_vid)
                ->where('forecast_items_view.item_id', $item_id);
        })->leftJoin('forecast_criterias_view', function($join) use ($model_id, $model_vid, $item_id) {
            $join->on('forecast_devices.market_id', '=', 'forecast_criterias_view.location_id')
            ->on('forecast_devices.project_id', '=', 'forecast_criterias_view.project_id')
            ->on('forecast_devices.date', '=', 'forecast_criterias_view.date')
                ->where('forecast_criterias_view.model_id', $model_id)
                ->where('forecast_criterias_view.model_vid', $model_vid)
                ->where('forecast_criterias_view.item_id', $item_id);
        })->get();

        $insertData = [];
        foreach ($results as $result) {
            array_push($insertData, [
                'model_id' => $model_id,
                'model_vid' => $model_vid,
                'project_id' => $result->project_id,
                'location_id' => $result->location_id,
                'date' => $result->date,
                'item_id' => $result->item_id,
                'result' => $result->value
            ]);
            if (count($insertData) > 7000) {
                ModelResult::insert($insertData);
                $insertData = [];
            }
        }

        if ($insertData) {
            ModelResult::insert($insertData);
        }

    }


    private function getCountrys($ls) {
        $countrys = [];
        foreach ($ls as $l) {
            $temp = [];
            $this->getChildLocations($l, $temp);

            $countrys = array_merge($countrys, $temp);
        }

        return $countrys;
    }

    private function expandForecastCriterias($modelId, $modelVid) {

        DB::table('forecast_criterias_view')->where('model_id', $modelId)->where('model_vid', $modelVid)->delete();

        $insertData = [];
        $forecastCriterias = ForecastCriteria::with(['accounts', 'locations', 'parameters', 'item'])->where('model_id', $modelId)->where('model_vid', $modelVid)->get();

        foreach ($forecastCriterias as $forecastCriteria) {
            $projects = Project::where(function ($q1) use ($forecastCriteria) {
                if ($forecastCriteria->oem_id) {
                    $q1->whereIn('oem_id', $forecastCriteria->oem_id);
                }
                if ($forecastCriteria->odm_id) {
                    $q1->whereIn('odm_id', $forecastCriteria->odm_id);
                }
                if ($forecastCriteria->carrier_id) {
                    $q1->whereIn('carrier_id', $forecastCriteria->carrier_id);
                }
            })->get();

            $project_ids = [];
            foreach ($projects as $project) {
                array_push($project_ids, $project->id);
            }

            $markets = $forecastCriteria->locations;
            $market_ids = [];
            foreach ($markets as $market) {
                array_push($market_ids, $market->id);
            }

            foreach ($market_ids as $market_id) {
                foreach ($project_ids as $project_id) {
                    $parameters = $forecastCriteria->parameters;
                    foreach ($parameters as $parameter) {
                        $start = $parameter->date_from;
                        $date_from = Carbon::parse($parameter->date_from);
                        $date_to = Carbon::parse($parameter->date_to);
                        $value = $parameter->value;
                        $monthly_growth = $parameter->monthly_growth;
                        while ($date_from->lte($date_to)) {
                            array_push($insertData, [
                                'model_id' => $modelId,
                                'model_vid' => $modelVid,
                                'item_id' => $forecastCriteria->item_id,
                                'project_id' => $project_id,
                                'location_id' => $market_id,
                                'criteria_id' => $parameter->criteria_id,
                                'value' => $value,
                                'date' => $date_from->toDateString(),
                                'date_from' => $start
                            ]);
                            $value = $value * (1 + $monthly_growth);
                            if (count($insertData) > 7000) {
                                ForecastCriteriasView::insert($insertData);
                                $insertData = [];
                            }
                            $date_from->addMonth();
                        }
                    }
                }
            }
        }
        if ($insertData) {
            ForecastCriteriasView::insert($insertData);
        }
    }

    public function installBaseCalculate($model_id, $model_vid, $item_id) {
        $results = DB::table('forecast_devices')->select(
            'forecast_devices.location_id',
            'forecast_devices.project_id',
            'forecast_devices.date',
            'forecast_devices.quantity',
            'forecast_devices.market_id',
            'forecast_items_view.item_id',
            'forecast_items_view.coverage',
            'forecast_items_view.date_from',
            'forecast_criterias_view.criteria_id',
            'forecast_criterias_view.value')
            ->join('forecast_items_view', function ($join) use ($model_id, $model_vid, $item_id) {
                $join->on('forecast_devices.market_id', '=', 'forecast_items_view.location_id')
                    ->on('forecast_devices.project_id', '=', 'forecast_items_view.project_id')
                    ->on('forecast_devices.date', '=', 'forecast_items_view.date')
                    ->where('forecast_items_view.model_id', $model_id)
                    ->where('forecast_items_view.model_vid', $model_vid)
                    ->where('forecast_items_view.item_id', $item_id);
            })->leftJoin('forecast_criterias_view', function($join) use ($model_id, $model_vid, $item_id) {
                $join->on('forecast_devices.market_id', '=', 'forecast_criterias_view.location_id')
                    ->on('forecast_devices.project_id', '=', 'forecast_criterias_view.project_id')
                    ->on('forecast_devices.date', '=', 'forecast_criterias_view.date')
                    ->where('forecast_criterias_view.model_id', $model_id)
                    ->where('forecast_criterias_view.model_vid', $model_vid)
                    ->where('forecast_criterias_view.item_id', $item_id);
            })->get();

        $container = [];
        foreach ($results as $result) {
            if (isset($container[$result->location_id][$result->project_id][$result->date])) {
                $container[$result->location_id][$result->project_id][$result->date][$result->criteria_id]=$result;
            } else {
                $container[$result->location_id][$result->project_id][$result->date][$result->criteria_id]=$result;
            }

        }

        $insertData = [];
        foreach ($container as $location) {


            foreach ($location as $project) {
                $temp = [];
                foreach ($project as $date) {
                    $churnRate = (double)$date[2]->value;
                    $lifetime = (int)$date[3]->value;
                    $base = $date[2];
                    $quantity = (double)$base->quantity;
                    $data = [
                        'model_id' => $model_id,
                        'model_vid' => $model_vid,
                        'item_id' => $base->item_id,
                        'location_id' => $base->location_id,
                        'project_id' => $base->project_id,
                        'date' => $base->date
                    ];
                    if ($base->date_from == $base->date) {
                        $data['result'] = $quantity;
                        $temp[$base->date] = [
                            'quantity' => $quantity,
                            'install_base' => $data['result']
                        ];
                    } elseif (count($temp) < $lifetime ) {
                        $prevMonth = Carbon::parse($base->date)->subMonth()->toDateString();
                        $data['result'] = $temp[$prevMonth]['install_base'] * (1 - $churnRate) +  $quantity;
                        $temp[$base->date] = [
                            'quantity' => $quantity,
                            'install_base' => $data['result']
                        ];
                    } elseif (count($temp) >= $lifetime) {
                        $prevMonth = Carbon::parse($base->date)->subMonth()->toDateString();
                        $prevLifeMonth = Carbon::parse($base->date)->subMonths($lifetime)->toDateString();
                        $data['result'] = $temp[$prevMonth]['install_base'] * (1 - $churnRate) + $quantity - (1 - $lifetime * $churnRate) * $temp[$prevLifeMonth]['install_base'];
                        $temp[$base->date] = [
                            'quantity' => $quantity,
                            'install_base' => $data['result']
                        ];
                    }
                    array_push($insertData, $data);
                }
            }
            if (count($insertData) > BULK_NUMBER) {
                ModelResult::insert($insertData);
                $insertData = [];
            }
        }
        if ($insertData) {
            ModelResult::insert($insertData);
        }
    }

    public function mAUCaculate($model_id, $model_vid, $item_id) {
        $item_install_base = 3;
        $item_active_device = 4;
        $searchs = DB::table('forecast_devices')->select(
            'forecast_devices.location_id',
            'forecast_devices.project_id',
            'forecast_devices.date',
            'forecast_devices.quantity',
            'forecast_items_view.item_id',
            'forecast_items_view.coverage',
            'forecast_items_view.date_from',
            'forecast_criterias_view.criteria_id',
            'forecast_criterias_view.value',
            'install_base.result as install_base',
            'install_base.result as active_device'
        )
            ->join('forecast_items_view', function ($join) use ($model_id, $model_vid, $item_id) {
                $join->on('forecast_devices.market_id', '=', 'forecast_items_view.location_id')
                    ->on('forecast_devices.project_id', '=', 'forecast_items_view.project_id')
                    ->on('forecast_devices.date', '=', 'forecast_items_view.date')
                    ->where('forecast_items_view.model_id', $model_id)
                    ->where('forecast_items_view.model_vid', $model_vid)
                    ->where('forecast_items_view.item_id', $item_id);
            })->join('model_results as install_base', function ($join) use ($model_id, $model_vid, $item_install_base) {
                $join->on('forecast_devices.location_id', '=', 'install_base.location_id')
                    ->on('forecast_devices.project_id', '=', 'install_base.project_id')
                    ->on('forecast_devices.date', '=', 'install_base.date')
                    ->where('install_base.model_id', $model_id)
                    ->where('install_base.model_vid', $model_vid)
                    ->where('install_base.item_id', $item_install_base);
            })->join('model_results as active_device', function ($join) use ($model_id, $model_vid, $item_active_device) {
                $join->on('forecast_devices.location_id', '=', 'active_device.location_id')
                    ->on('forecast_devices.project_id', '=', 'active_device.project_id')
                    ->on('forecast_devices.date', '=', 'active_device.date')
                    ->where('active_device.model_id', $model_id)
                    ->where('active_device.model_vid', $model_vid)
                    ->where('active_device.item_id', $item_active_device);
            })->leftJoin('forecast_criterias_view', function($join) use ($model_id, $model_vid, $item_id) {
                $join->on('forecast_devices.market_id', '=', 'forecast_criterias_view.location_id')
                    ->on('forecast_devices.project_id', '=', 'forecast_criterias_view.project_id')
                    ->on('forecast_devices.date', '=', 'forecast_criterias_view.date')
                    ->where('forecast_criterias_view.model_id', $model_id)
                    ->where('forecast_criterias_view.model_vid', $model_vid)
                    ->where('forecast_criterias_view.item_id', $item_id);
            })->get();

        $container = [];
        foreach ($searchs as $result) {
            if (isset($container[$result->location_id][$result->project_id][$result->date])) {
                $container[$result->location_id][$result->project_id][$result->date][$result->criteria_id]=$result;
            } else {
                $container[$result->location_id][$result->project_id][$result->date][$result->criteria_id]=$result;
            }
        }
        $insertData = [];
        foreach ($container as $location) {


            foreach ($location as $project) {
                $temp = [];
                foreach ($project as $date) {
                    $initialMAURatio = (double)$date[5]->value;
                    $growthFactor = (double)$date[6]->value;
                    $base = $date[5];
                    $installBase = $base->install_base;
                    $activeDevice = $base->active_device;
                    $data = [
                        'model_id' => $model_id,
                        'model_vid' => $model_vid,
                        'item_id' => $base->item_id,
                        'location_id' => $base->location_id,
                        'project_id' => $base->project_id,
                        'date' => $base->date
                    ];
                    if ($base->date_from == $base->date) {
                        $data['result'] = $activeDevice * $initialMAURatio;
                        $temp[$base->date] = [
                            'mau' => $data['result'],
                            'install_base' => $installBase
                        ];
                    } else {
                        $prevMonth = Carbon::parse($base->date)->subMonth()->toDateString();
                        if ($temp[$prevMonth]['install_base'] == 0) {
                            $data['result'] = 0;
                        } else {
                            $data['result'] = $temp[$prevMonth]['mau'] * (($installBase / $temp[$prevMonth]['install_base']) * $growthFactor);
                        }
                        $temp[$base->date] = [
                            'mau' => $data['result'],
                            'install_base' => $installBase
                        ];
                    }
                    array_push($insertData, $data);
                }
                if (count($insertData) > BULK_NUMBER) {
                    ModelResult::insert($insertData);
                    $insertData = [];
                }
            }

            if ($insertData) {
                ModelResult::insert($insertData);
            }

        }

        if ($insertData) {
            ModelResult::insert($insertData);
        }
    }

    public function expandForecastItem($modelId, $modelVid) {
        DB::table('forecast_items_view')->where('model_id', $modelId)->where('model_vid', $modelVid)->delete();

        $forecastItems = ForecastItem::with(['locations', 'items'])->where('model_id', $modelId)->where('model_vid', $modelVid)->get();

        $insertData = [];

        foreach ($forecastItems as $forecastItem) {

            $projects = Project::where(function ($q1) use ($forecastItem) {
                if ($forecastItem->oem_id) {
                    $q1->whereIn('oem_id', $forecastItem->oem_id);
                }
                if ($forecastItem->odm_id) {
                    $q1->whereIn('odm_id', $forecastItem->odm_id);
                }
                if ($forecastItem->carrier_id) {
                    $q1->whereIn('carrier_id', $forecastItem->carrier_id);
                }
            })->get();

            $project_ids = [];
            foreach ($projects as $project) {
                array_push($project_ids, $project->id);
            }

            $markets = $forecastItem->locations;
            $market_ids = [];
            foreach ($markets as $market) {
                array_push($market_ids, $market->id);
            }

            foreach ($project_ids as $project_id) {
                foreach ($market_ids as $market_id) {
                    foreach ($forecastItem->items as $item) {
                        $start = $forecastItem->date_from;
                        $date_from = Carbon::parse($forecastItem->date_from);
                        $date_to = Carbon::parse($forecastItem->date_to);
                        $coverage = $forecastItem->coverage;
                        $monthly_growth = $forecastItem->monthly_growth;
                        while ($date_from->lte($date_to)) {
                            ForecastItemsView::create([
                            'model_id' => $modelId,
                            'model_vid' => $modelVid,
                            'item_id' => $item->id,
                            'location_id' => $market_id,
                            'project_id' => $project_id,
                            'coverage' => $coverage,
                            'date' => $date_from->toDateString(),
                            'date_from' => $start
                        ]);
                            $coverage = $coverage * ( 1 + $monthly_growth);
                            if (count($insertData) > BULK_NUMBER) {
                                ForecastItemsView::insert($insertData);
                                $insertData = [];
                            }
                            $date_from->addMonth();
                        }
                    }
                }
            }
        }

        if ($insertData) {
            ForecastCriteriasView::insert($insertData);
        }
    }


    private function getChildLocations(Location $l, &$countrys) {
        if ($l->level_type == 'Country') {
            array_push($countrys, $l->id);
        } else {
            $locations = Location::where('parent_id', $l->id)->get();
            foreach ($locations as $location) {
                $this->getChildLocations($location, $countrys);
            }
        }
    }
}
