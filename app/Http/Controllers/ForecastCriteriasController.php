<?php

namespace App\Http\Controllers;

use App\Models\Criteria;
use App\Models\Item;
use App\Models\Account;
use App\Models\Location;
use App\Models\DataModel;
use App\Models\ForecastCriteria;
use App\Models\ForecastCriteriaAccount;
use App\Models\ForecastCriteriaLocation;
use App\Models\ForecastCriteriaParameter;

use Illuminate\Http\Request;

class ForecastCriteriasController extends Controller
{
    public function index(Request $request)
    {
        $modelId = $request->get('model_id');
        $modelVid = $request->get('model_vid');

        $forecastCriterias = ForecastCriteria::with(['item', 'parameters', 'accounts', 'locations'])->where('model_id', $modelId)->where('model_vid', $modelVid)->get();
        return view('forecast-criterias.index', compact('forecastCriterias','modelId', 'modelVid'));
    }

    public function edit(Request $request, ForecastCriteria $forecastCriteria)
    {
        $model = DataModel::where('id', $forecastCriteria->model_id)->where('vid', $forecastCriteria->model_vid)->first();
        $items = Item::with(['parent'])->where('level_type', 'Item')->get();

        $oem = Account::where('name', 'OEM')->first();
        $odm = Account::where('name', 'ODM')->first();
        $carrier = Account::where('name', 'Carrier')->first();

        $oemOptions = Account::with(['parent'])->where('level_type', 'Account')->where('parent_id', $oem->id)->get();
        $odmOptions = Account::with(['parent'])->where('level_type', 'Account')->where('parent_id', $odm->id)->get();
        $carrierOptions = Account::with(['parent'])->where('level_type', 'Account')->where('parent_id', $carrier->id)->get();
        $locations = Location::with(['parent'])->where('level_type', 'Market')->get();


        $criterias = Criteria::all();

        $selectLocations = [];
        foreach ($forecastCriteria->locations as $location) {
            array_push($selectLocations, $location->id);
        }
        $selectLocations = json_encode($selectLocations);

        return view('forecast-criterias.edit', compact('oemOptions','odmOptions', 'carrierOptions','selectLocations','forecastCriteria','model','items', 'locations', 'criterias'));
    }

    public function update(Request $request, ForecastCriteria $forecastCriteria)
    {
        $forecastCriteria->fill($request->all());
        $forecastCriteria->save();

        $forecastCriteriaLocation = ForecastCriteriaLocation::find($forecastCriteria->id);
        if ($forecastCriteriaLocation) {
            $forecastCriteriaLocation->delete();
        }
        foreach ( $request->get('locations', []) as $location)
        {
            ForecastCriteriaLocation::firstOrCreate(['id' => $forecastCriteria->id, 'location_id' => $location]);
        }

        $forecastCriteriaParameter = ForecastCriteriaParameter::where('forecast_criteria_id', $forecastCriteria->id);
        if ($forecastCriteriaParameter) {
            $forecastCriteriaParameter->delete();
        }
        foreach ( $request->get('parameters', []) as $parameter)
        {
            ForecastCriteriaParameter::firstOrCreate([
                'forecast_criteria_id' => $forecastCriteria->id,
                'criteria_id' => $parameter['criteria_id'],
                'value' => $parameter['value'],
                'monthly_growth' => $parameter['monthly_growth'],
                'date_from' => $parameter['date_from'],
                'date_to' => $parameter['date_to']
            ]);
        }

        return redirect(
            route('forecast-criterias.index', array(
                'model_id' => $forecastCriteria->model_id,
                'model_vid' => $forecastCriteria->model_vid
            ))
        );

    }

    public function create(Request $request)
    {
        $modelId = $request->get('model_id');
        $modelVid = $request->get('model_vid');

        $model = DataModel::where('id', $modelId)->where('vid', $modelVid)->first();
        $items = Item::with(['parent'])->where('level_type', 'Item')->get();
        $oem = Account::where('name', 'OEM')->first();
        $odm = Account::where('name', 'ODM')->first();
        $carrier = Account::where('name', 'Carrier')->first();

        $oemOptions = Account::with(['parent'])->where('level_type', 'Account')->where('parent_id', $oem->id)->get();
        $odmOptions = Account::with(['parent'])->where('level_type', 'Account')->where('parent_id', $odm->id)->get();
        $carrierOptions = Account::with(['parent'])->where('level_type', 'Account')->where('parent_id', $carrier->id)->get();
        $locations = Location::with(['parent'])->where('level_type', 'Market')->get();

        $criterias = Criteria::all();

        return view('forecast-criterias.create', compact('oemOptions', 'odmOptions', 'carrierOptions','model','items', 'locations', 'modelId', 'modelVid', 'criterias'));
    }

    public function store(Request $request, ForecastCriteria $forecastCriteria)
    {
        $forecastCriteria->fill($request->all());
        $forecastCriteria->save();
        foreach ( $request->get('locations', []) as $location)
        {
            ForecastCriteriaLocation::firstOrCreate(['id' => $forecastCriteria->id, 'location_id' => $location]);
        }

        foreach ( $request->get('parameters', []) as $parameter)
        {
            ForecastCriteriaParameter::firstOrCreate([
                'forecast_criteria_id' => $forecastCriteria->id,
                'criteria_id' => $parameter['criteria_id'],
                'value' => $parameter['value'],
                'monthly_growth' => $parameter['monthly_growth'],
                'date_from' => $parameter['date_from'],
                'date_to' => $parameter['date_to']
            ]);
        }

        return redirect(
            route('forecast-criterias.index', array(
                'model_id' => $forecastCriteria->model_id,
                'model_vid' => $forecastCriteria->model_vid
            ))
        );
    }



    public function destroy(Request $request, ForecastCriteria $forecastCriteria)
    {
        $forecastCriteria->delete();

        $forecastCriteriaParameter = ForecastCriteriaParameter::where('forecast_criteria_id', $forecastCriteria->id);
        if ($forecastCriteriaParameter) {
            $forecastCriteriaParameter->delete();
        }

        $forecastCriteriaLocation = ForecastCriteriaLocation::find($forecastCriteria->id);
        if ($forecastCriteriaLocation) {
            $forecastCriteriaLocation->delete();
        }

        return back();
    }
}
