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

    }
}
