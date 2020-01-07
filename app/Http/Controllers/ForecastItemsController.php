<?php

namespace App\Http\Controllers;

use App\Models\DataModel;

use App\Models\Item;
use App\Models\ForecastItem;
use App\Models\ForecastItemItem;
use App\Models\ForecastItemAccount;
use App\Models\ForecastItemLocation;


use App\Models\Licensee;
use App\Models\Location;
use App\Models\Account;
use App\Models\Type;
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

        $selectItems = [];
        foreach ($forecastItem->items as $item) {
            array_push($selectItems, $item->id);
        }
        $selectItems = json_encode($selectItems);


        $model = DataModel::where('id', $forecastItem->model_id)->where('vid', $forecastItem->model_vid)->first();
        $items = Item::with(['parent'])->where('level_type', 'Item')->get();
        $oem = Account::where('name', 'OEM')->first();
        $odm = Account::where('name', 'ODM')->first();
        $carrier = Account::where('name', 'Carrier')->first();

        $types = Type::all();
        $licensees = Licensee::all();

        $oemOptions = Account::with(['parent'])->where('level_type', 'Account')->where('parent_id', $oem->id)->get();
        $odmOptions = Account::with(['parent'])->where('level_type', 'Account')->where('parent_id', $odm->id)->get();
        $carrierOptions = Account::with(['parent'])->where('level_type', 'Account')->where('parent_id', $carrier->id)->get();
        $locations = Location::with(['parent'])->where('level_type', 'Market')->get();

        return view('forecast-items.edit', compact('types','licensees','locations','oemOptions', 'odmOptions', 'carrierOptions','items','forecastItem', 'selectLocations', 'selectItems', 'model'));
    }

    public function update(Request $request, ForecastItem $forecastItem)
    {
        $forecastItem->fill($request->all());
        $forecastItem->save();

        $forecastItemLocation = ForecastItemLocation::find($forecastItem->id);
        if ($forecastItemLocation) {
            $forecastItemLocation->delete();
        }

        foreach ($request->get('locations', []) as $location)  {
            ForecastItemLocation::firstOrCreate(['id' => $forecastItem->id, 'location_id' => $location]);
        }

        $forecastItemItem = ForecastItemItem::find($forecastItem->id);
        if ($forecastItemItem) {
            $forecastItemItem->delete();
        }

        foreach ($request->get('items', []) as $item)  {
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
        $items = Item::with(['parent'])->where('level_type', 'Item')->get();
        $oem = Account::where('name', 'OEM')->first();
        $odm = Account::where('name', 'ODM')->first();
        $carrier = Account::where('name', 'Carrier')->first();

        $types = Type::all();
        $licensees = Licensee::all();

        $oemOptions = Account::with(['parent'])->where('level_type', 'Account')->where('parent_id', $oem->id)->get();
        $odmOptions = Account::with(['parent'])->where('level_type', 'Account')->where('parent_id', $odm->id)->get();
        $carrierOptions = Account::with(['parent'])->where('level_type', 'Account')->where('parent_id', $carrier->id)->get();

        $locations = Location::with(['parent'])->where('level_type', 'Market')->get();


        return view('forecast-items.create', compact('types','licensees', 'oemOptions', 'odmOptions', 'carrierOptions', 'model', 'items', 'locations', 'modelId', 'modelVid'));
    }

    public function store(Request $request, ForecastItem $forecastItem)
    {
        $forecastItem->fill($request->all());
        $forecastItem->save();

        foreach ($request->get('locations', []) as $location)  {
            ForecastItemLocation::create(['id' => $forecastItem->id, 'location_id' => $location]);
        }

        foreach ($request->get('items', []) as $item)  {
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
        return back();
    }
}
