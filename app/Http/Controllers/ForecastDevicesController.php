<?php

namespace App\Http\Controllers;

use App\Models\ForecastDevice;
use Illuminate\Http\Request;

class ForecastDevicesController extends Controller
{
    public function index(Request $request)
    {
        $forecastDevices = ForecastDevice::with('location', 'project')->get();
        $modelId = $request->get('model_id');
        $modelVid = $request->get('model_vid');
        return view('forecast-devices.index', compact('forecastDevices', 'modelId', 'modelVid'));
    }
}
