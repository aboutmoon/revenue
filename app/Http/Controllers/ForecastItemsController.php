<?php

namespace App\Http\Controllers;

use App\Models\DataModel;

use App\Models\Item;
use App\Models\ForecastItem;
use App\Models\ForecastItemItem;
use App\Models\ForecastItemAccount;
use App\Models\ForecastItemLocation;


use App\Models\Location;
use App\Models\Account;
use Illuminate\Http\Request;

class ForecastItemsController extends Controller
{
    public function index(Request $request)
    {
        $modelId = $request->get('model_id');
        $modelVid = $request->get('model_vid');

        $forecastItems = ForecastItem::where('model_id', $modelId)->where('model_vid', $modelVid)->get();
        return view('forecast-items.index', compact('forecastItems','modelId', 'modelVid'));
    }

    public function edit(Request $request, ForecastItem $forecastItem)
    {
        $selectLocations = [];
        foreach ($forecastItem->locations as $location) {
            array_push($selectLocations, $location->id);
        }
        $selectLocations = json_encode($selectLocations);

        $selectAccounts = [];
        foreach ($forecastItem->accounts as $account) {
            array_push($selectAccounts, $account->id);
        }
        $selectAccounts = json_encode($selectAccounts);

        $selectItems = [];
        foreach ($forecastItem->items as $item) {
            array_push($selectItems, $item->id);
        }
        $selectItems = json_encode($selectItems);


        $model = DataModel::where('id', $forecastItem->model_id)->where('vid', $forecastItem->model_vid)->first();
        $items = Item::where('level_type', 'Item')->get();
        $accounts = Account::where('level_type', 'Account')->get();
        $locations = Location::where('level_type', 'Market')->get();

        $json_accounts = json_encode($accounts);

        return view('forecast-items.edit', compact('locations','accounts','items','forecastItem', 'selectLocations', 'selectAccounts', 'selectItems', 'model', 'json_accounts'));
    }

    public function update(Request $request, ForecastItem $forecastItem)
    {
        $forecastItem->fill($request->all());
        $forecastItem->save();

        ForecastItemLocation::find($forecastItem->id)->delete();
        foreach ($request->get('locations') as $location)  {
            ForecastItemLocation::firstOrCreate(['id' => $forecastItem->id, 'location_id' => $location]);
        }

        ForecastItemAccount::find($forecastItem->id)->delete();
        foreach ($request->get('accounts') as $account)  {
            ForecastItemAccount::firstOrCreate(['id' => $forecastItem->id, 'account_id' => $account]);
        }

        ForecastItemItem::find($forecastItem->id)->delete();
        foreach ($request->get('items') as $item)  {
            ForecastItemItem::firstOrCreate(['id' => $forecastItem->id, 'item_id' => $item]);
        }


        return redirect(
            route('forecast-items.index', array(
                'model_id' => $forecastItem->model_id,
                'model_vid' => $forecastItem->model_vid
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

        $json_accounts = json_encode($accounts);

        return view('forecast-items.create', compact('json_accounts','model','items', 'accounts', 'locations', 'modelId', 'modelVid'));
    }

    public function store(Request $request, ForecastItem $forecastItem)
    {
        $forecastItem->fill($request->all());
        $forecastItem->save();

        foreach ($request->get('locations') as $location)  {
            ForecastItemLocation::create(['id' => $forecastItem->id, 'location_id' => $location]);
        }

        foreach ($request->get('accounts') as $account)  {
            ForecastItemAccount::create(['id' => $forecastItem->id, 'account_id' => $account]);
        }

        foreach ($request->get('items') as $item)  {
            ForecastItemItem::create(['id' => $forecastItem->id, 'item_id' => $item]);
        }

        return redirect(
            route('forecast-items.index', array(
                'model_id' => $forecastItem->model_id,
                'model_vid' => $forecastItem->model_vid
            ))
        );

    }



    public function destroy(Request $request, ForecastItem $forecastItem)
    {
        $forecastItem->delete();
        ForecastItemItem::find($forecastItem->id)->delete();
        ForecastItemLocation::find($forecastItem->id)->delete();
        ForecastItemAccount::find($forecastItem->id)->delete();
        return back();
    }
}
