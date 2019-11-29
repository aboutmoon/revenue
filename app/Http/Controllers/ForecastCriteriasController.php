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
//|        | POST      | forecast-criterias                          | forecast-criterias.store   | App\Http\Controllers\ForecastCriteriasController@store            | web,auth                                             |
//|        | GET|HEAD  | forecast-criterias                          | forecast-criterias.index   | App\Http\Controllers\ForecastCriteriasController@index            | web,auth                                             |
//|        | GET|HEAD  | forecast-criterias/create                   | forecast-criterias.create  | App\Http\Controllers\ForecastCriteriasController@create           | web,auth                                             |
//|        | GET|HEAD  | forecast-criterias/{forecast_criteria}      | forecast-criterias.show    | App\Http\Controllers\ForecastCriteriasController@show             | web,auth                                             |
//|        | DELETE    | forecast-criterias/{forecast_criteria}      | forecast-criterias.destroy | App\Http\Controllers\ForecastCriteriasController@destroy          | web,auth                                             |
//|        | PUT|PATCH | forecast-criterias/{forecast_criteria}      | forecast-criterias.update  | App\Http\Controllers\ForecastCriteriasController@update           | web,auth                                             |
//|        | GET|HEAD  | forecast-criterias/{forecast_criteria}/edit | forecast-criterias.edit    | App\Http\Controllers\ForecastCriteriasController@edit             | web,auth
class ForecastCriteriasController extends Controller
{
    public function index(Request $request)
    {
        $modelId = $request->get('model_id');
        $modelVid = $request->get('model_vid');

        $forecastCriterias = ForecastCriteria::where('model_id', $modelId)->where('model_vid', $modelVid)->get();
        return view('forecast-criterias.index', compact('forecastCriterias','modelId', 'modelVid'));
    }

    public function edit(Request $request, ForecastCriteria $forecastCriteria)
    {
        $model = DataModel::where('id', $forecastCriteria->model_id)->where('vid', $forecastCriteria->model_vid)->first();
        $items = Item::where('level_type', 'Item')->get();
        $accounts = Account::where('level_type', 'Account')->get();
        $locations = Location::where('level_type', 'Market')->get();

        $criterias = Criteria::all();

        $selectLocations = [];
        foreach ($forecastCriteria->locations as $location) {
            array_push($selectLocations, $location->id);
        }
        $selectLocations = json_encode($selectLocations);

        $selectAccounts = [];
        foreach ($forecastCriteria->accounts as $account) {
            array_push($selectAccounts, $account->id);
        }
        $selectAccounts = json_encode($selectAccounts);

        return view('forecast-criterias.edit', compact('selectAccounts','selectLocations','forecastCriteria','model','items', 'accounts', 'locations', 'criterias'));
    }

    public function update(Request $request, ForecastCriteria $forecastCriteria)
    {
        $forecastCriteria->fill($request->all());
        $forecastCriteria->save();

        ForecastCriteriaLocation::find($forecastCriteria->id)->delete();
        foreach ( $request->locations as $location)
        {
            ForecastCriteriaLocation::firstOrCreate(['id' => $forecastCriteria->id, 'location_id' => $location]);
        }

        ForecastCriteriaAccount::find($forecastCriteria->id)->delete();
        foreach ( $request->accounts as $account)
        {
            ForecastCriteriaAccount::firstOrCreate(['id' => $forecastCriteria->id, 'account_id' => $account]);
        }

        ForecastCriteriaParameter::where('forecast_criteria_id', $forecastCriteria->id)->delete();
        foreach ( $request->parameters as $parameter)
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
        $items = Item::where('level_type', 'Item')->get();
        $accounts = Account::where('level_type', 'Account')->get();
        $locations = Location::where('level_type', 'Market')->get();

        $criterias = Criteria::all();

        return view('forecast-criterias.create', compact('model','items', 'accounts', 'locations', 'modelId', 'modelVid', 'criterias'));
    }

    public function store(Request $request, ForecastCriteria $forecastCriteria)
    {
        $forecastCriteria->fill($request->all());
        $forecastCriteria->save();
        foreach ( $request->locations as $location)
        {
            ForecastCriteriaLocation::firstOrCreate(['id' => $forecastCriteria->id, 'location_id' => $location]);
        }

        foreach ( $request->accounts as $account)
        {
            ForecastCriteriaAccount::firstOrCreate(['id' => $forecastCriteria->id, 'account_id' => $account]);
        }

        foreach ( $request->parameters as $parameter)
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

        return back();
    }
}
