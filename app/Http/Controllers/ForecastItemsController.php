<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ForecastItemsController extends Controller
{
    public function index(Request $request) {

        return view('forecastitems.index');
    }
}
