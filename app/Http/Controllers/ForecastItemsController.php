<?php

namespace App\Http\Controllers;

use App\Models\ForecastItem;
use App\Models\Item;
use App\Models\Location;
use App\Models\Account;
use Illuminate\Http\Request;

class ForecastItemsController extends Controller
{
    public function index(Request $request)
    {
        $modelId = $request->get('model_id');
        $modelVid = $request->get('model_vid');

        $forecastItems = ForecastItem::with('accounts', 'locations', 'items')->get();
        $items = Item::where('level_type', 'Item')->get();
        $accounts = Account::where('level_type', 'Account')->get();
        $locations = Location::where('level_type', 'Location')->get();

        return view('forecast-items.index', compact('forecastItems', 'items', 'accounts', 'locations', 'modelId', 'modelVid'));
    }
}
