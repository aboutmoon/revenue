<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Location;
use App\Models\ModelResult;
use App\Models\User;
use App\Models\DataModel;
use App\Models\ForecastDevice;
use App\Models\ForecastDevicesView;
use App\Models\ForecastItem;
use App\Models\ForecastItemsView;
use App\Models\ForecastCriteriasView;
use App\Models\ForecastCriteria;
use App\Models\Project;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use PhpParser\Node\Expr\Array_;

class DataModelsController extends Controller
{
    public function index(Request $request)
    {
        $models = DataModel::with('user')->get();
        return view('data-models.index', compact('models'));
    }

    public function create(Request $request)
    {
        return view('data-models.create');
    }

    public function edit(Request $request)
    {
        return view('data-models.edit');
    }
//$table->bigInteger('model_id');
//$table->bigInteger('model_vid');
//$table->bigInteger('carrier_id')->default(0);
//$table->bigInteger('oem_id')->default(0);
//$table->bigInteger('odm_id')->default(0);
//$table->string('project');
//$table->string('connectivity')->default('');
//$table->string('brand');
//$table->string('licensee');
//$table->string('type');
//$table->bigInteger('location_id');
//$table->date('date');
//$table->decimal('quantity', 24, 8)->default(0);
    private function expandForecastDevices()
    {
        $forecastDevices = ForecastDevice::all();
        foreach ($forecastDevices as $forecastDevice) {
            $date_from = Carbon::parse($forecastDevice->date_from);
            $date_to = Carbon::parse($forecastDevice->date_to);
            while ($date_from->lte($date_to)) {
                ForecastDevicesView::create([
                    'model_id' => $forecastDevice->model_id,
                    'model_vid' => $forecastDevice->model_vid,
                    'carrier_id' => $forecastDevice->project->carrier_id? $forecastDevice->project->carrier_id: 0,
                    'oem_id' => $forecastDevice->project->oem_id? $forecastDevice->project->oem_id: 0,
                    'odm_id' => $forecastDevice->project->odm_id? $forecastDevice->project->odm_id: 0,
                    'connectivity' => $forecastDevice->project->connectivity?$forecastDevice->project->connectivity: '',
                    'brand' => $forecastDevice->project->brand?$forecastDevice->project->brand: '',
                    'licensee' => $forecastDevice->project->licensee?$forecastDevice->project->licensee: '',
                    'type' => $forecastDevice->project->type?$forecastDevice->project->type: '',
                    'location_id' => $forecastDevice->location_id?$forecastDevice->location_id: 0,
                    'date' => $date_from->toDateString(),
                    'quantity' => $forecastDevice->quantity,
                    'project' => $forecastDevice->project->name
                ]);
                $date_from->addMonth();
            }
        }
    }
    public function generate(Request $request)
    {
        $modelId = $request->get('model_id');
        $modelVid = $request->get('model_vid');

        //release device
//        $this->expandForecastDevices();

        // expand criteria
//        DB::table('forecast_criterias_view')->delete();
//        $this->expandForecastCriterias($modelId, $modelVid);

        //use account to select project, and use location + project + date to select forecast device
        $forecastItems = ForecastItem::where('model_id', $modelId)->where('model_vid', $modelVid)->get();

        $oem = Account::where('level_type', 'Category')->where('name', 'OEM')->first();
        $odm = Account::where('level_type', 'Category')->where('name', 'ODM')->first();
        $carrier = Account::where('level_type', 'Category')->where('name', 'Carrier')->first();
        foreach ($forecastItems as $forecastItem) {
            $date_from = Carbon::parse($forecastItem->date_from);
            $date_to = Carbon::parse($forecastItem->date_to);



            $oem_ids = [];
            $odm_ids = [];
            $carrier_ids = [];
            foreach ($forecastItem->accounts as $account) {
                $parent_id = $account->parent_id;
                if ($parent_id == $oem->id) {
                    array_push($oem_ids, $account->id);
                } elseif ($parent_id == $odm->id) {
                    array_push($odm_ids, $account->id);
                } elseif ($parent_id == $carrier->id) {
                    array_push($carrier_ids, $account->id);
                }
            }

            // get project by oem_id, odm_id, carrier_id
            $projects = Project::where(function ($q1) use($odm_ids, $oem_ids, $carrier_ids){
              if ($oem_ids) {
                  $q1->whereIn('oem_id', $oem_ids);
              }
              if ($odm_ids) {
                  $q1->whereIn('odm_id', $odm_ids);
              }
              if ($carrier_ids) {
                  $q1->whereIn('carrier_id', $carrier_ids);
              }
            })->get();
            $project_ids = [];
            foreach ($projects as $project) {
                array_push($project_ids, $project->id);
            }

            // get location in country level
            $country_ids = $this->getCountrys($forecastItem->locations);

            // get forecast devices by location_ids, project_ids, date_from, date_to

            foreach ($forecastItem->items as $item) {
                $forecasts = DB::table('forecast_devices')
                    ->where(function ($q1) use ($country_ids, $project_ids) {
                        if ($country_ids) {
                            $q1->whereIn('forecast_devices.location_id', $country_ids);
                        }
                        if ($project_ids) {
                            $q1->whereIn('forecast_devices.project_id', $project_ids);
                        }
                    })
                    ->where('forecast_devices.date', '>=', $forecastItem->date_from)
                    ->where('forecast_devices.date', '<=', $forecastItem->date_to)
                    ->where('forecast_devices.model_id', $modelId)
                    ->where('forecast_devices.model_vid', $modelVid)
                    ->get();

                foreach ($forecasts as $forecast) {
                    $forecastCriteriasView = ForecastCriteriasView::where('location_id', $forecast->location_id)
                        ->where('item_id', $item->id)
                        ->where('date', $forecast->date)->get();
                    if ($item->id == 2) {
                        ModelResult::create([
                            'model_id' => $forecast->model_id,
                            'model_vid' => $forecast->model_vid,
                            'project_id' => $forecast->project_id,
                            'location_id' => $forecast->location_id,
                            'item_id' => $item->id,
                            'date' => $forecast->date,
                            'date_from' => $forecast->date,
                            'date_to' => $forecast->date,
                            'result' => $forecast->quantity * $forecastItem->coverage * $forecastCriteriasView[0]->value
                        ]);
                    }
//                    ModelResult::create([
//                        'model_id' => $forecast->model_id,
//                        'model_vid' => $forecast->model_vid,
//                        'project_id' => $forecast->project_id,
//                        'location_id' => $forecast->location_id,
//                        'item_id' => $forecast->item_id,
//                        'date' => $forecast->date,
//                        'result' => $forecast->quantity * $forecastItem->coverage *
//                    ]);
//
//                    ->leftJoin('forecast_criterias_view', function($join) use ($item) {
//                        $join->on('forecast_devices.date', 'forecast_criterias_view.date')
//                            ->on('forecast_devices.location_id', 'forecast_criterias_view.location_id')
//                            ->on('forecast_devices.model_id', 'forecast_criterias_view.model_id')
//                            ->on('forecast_devices.model_vid', 'forecast_criterias_view.model_vid')
//                            ->where('forecast_criterias_view.item_id', $item->id);
//                    })
                }
//                foreach ($forecasts as $forecast) {
//                    ModelResult::create([
//                        'model_id' => $modelId,
//                        'model_vid' => $modelVid,
//                        'project_id' => $forecast->project_id,
//                        'location_id' => $forecast->location_id,
//                        'date' => $forecast->date,
//
//                    ]);
//                }
            }

        }
        return view('welcome');
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

//$table->bigInteger('model_id');
//$table->bigInteger('model_vid');
//$table->bigInteger('item_id');
//$table->bigInteger('location_id');
//$table->bigInteger('account_id');
//$table->bigInteger('criteria_id');
//$table->date('date');
//$table->decimal('value', 24, 8);
    private function expandForecastCriterias($modelId, $modelVid) {
        $forecastCriterias = ForecastCriteria::where('model_id', $modelId)->where('model_vid', $modelVid)->get();

        foreach ($forecastCriterias as $forecastCriteria) {

            $countrys = $this->getCountrys($forecastCriteria->locations);

            foreach ($countrys as $country) {
                foreach ($forecastCriteria->parameters as $parameter) {
                    $date_from = Carbon::parse($parameter->date_from);
                    $date_to = Carbon::parse($parameter->date_to);
                    while ($date_from->lte($date_to)) {
                        ForecastCriteriasView::create([
                            'model_id' => $modelId,
                            'model_vid' => $modelVid,
                            'item_id' => $forecastCriteria->item_id,
                            'location_id' => $country,
                            'criteria_id' => $parameter->criteria_id,
                            'value' => $parameter->value,
                            'date' => $date_from->toDateString()
                        ]);
                        $date_from->addMonth();
                    }

                }
            }

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
