<?php

namespace App\Http\Controllers;

use App\Models\ForecastItemsView;
use App\Models\ModelResult;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Carbon\Carbon;
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
use App\Models\User;
use App\Models\ForecastDevice;
use App\Models\ForecastDevicesView;
use App\Models\ForecastItem;
use App\Models\ForecastCriteriasView;
use App\Models\ForecastCriteria;
use App\Models\Project;

use Illuminate\Support\Facades\Log;
use PhpParser\Node\Expr\Array_;

const I_SHIPMENT = 2;
const I_INSTALL_BASE = 3;

const C_SHIPMENT = 1;
const C_CHURN_RATE = 2;
const C_DEVICE_LIFETIME = 3;

const BULK_NUMBER = 5000;

class HomeController extends Controller
{
    public function index() {
        return view('home');
    }

    public function abc ($modelId, $modelVid) {
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
    }

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
}
