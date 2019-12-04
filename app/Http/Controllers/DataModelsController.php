<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\DataModel;
use App\Models\ForecastDevice;
use App\Models\ForecastItem;
use App\Models\ForecastCriteria;
use App\Models\Project;
use Illuminate\Http\Request;

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


    public function generate(Request $request)
    {
        $modelId = $request->get('model_id');
        $modelVid = $request->get('model_vid');
        $forecastItems = ForecastItem::where('model_id', $modelId)->where('model_vid', $modelVid)->get();

        foreach ($forecastItems as $forecastItem)
        {
            $accounts = $forecastItems->accounts;
            $oems = [];
            $odms = [];
            $carriers = [];

            foreach ($accounts as $account) {
                if ($account->parent->name == 'OEM') {
                    array_push($oems, $account->id);
                } elseif ($account->parent->name == 'ODM') {
                    array_push($odms, $account->id);
                } elseif ($account->parent->name == 'Carrier') {
                    array_push($carriers, $account->id);
                }
            }

            $projects = Project::whereIn([
                'oem_id' => $oems,
                'odm_id' => $odms,
                'carrier' => $carriers
            ])->get();

            $project_ids = [];
            foreach ($projects as $project) {
                array_push($project_ids, $project->id);
            }


            $forecastDevice = ForecastDevice::whereIn([
                'project_id' => $project_ids,
                'location_id' => $location_id
            ]);



        }
    }
}
