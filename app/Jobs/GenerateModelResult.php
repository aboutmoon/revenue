<?php

namespace App\Jobs;

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
use PhpParser\Node\Expr\Array_;

class GenerateModelResult implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $modelId;
    protected $modelVid;

    public $tries = 5;
    public $timeout = 600;
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
        $dataModel = DataModel::where('id', $this->modelId)->where('vid', $this->modelVid)->first();
        $dataModel->status = $this->job->getJobId();
        $dataModel->save();
        $this->generate();
    }

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
    public function generate()
    {
        $modelId = $this->modelId;
        $modelVid = $this->modelVid;

        // release device
//        $this->expandForecastDevices();

        // expand criteria
        DB::table('forecast_criterias_view')->where('model_id', $modelId)->where('model_vid', $modelVid)->delete();
        $this->expandForecastCriterias($modelId, $modelVid);

        // remove results.
        DB::table('model_results')->where('model_id', $modelId)->where('model_vid', $modelVid)->delete();

        // use account to select project, and use location + project + date to select forecast device
        $forecastItems = ForecastItem::with(['locations', 'accounts'])->where('model_id', $modelId)->where('model_vid', $modelVid)->get();

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
                    if ($item->id == 2 || $item->id == 3) {

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

                }
            }

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
