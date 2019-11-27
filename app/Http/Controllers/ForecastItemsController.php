<?php

namespace App\Http\Controllers;

use App\Models\ForecastItem;
use Illuminate\Http\Request;

class ForecastItemsController extends Controller
{
    public function index(Request $request)
    {
        $forecastItems = ForecastItem::with('accounts', 'locations', 'items')->get();
//        dd($forecastItems);
        return view('forecast-items.index', compact('forecastItems'));
    }
}
