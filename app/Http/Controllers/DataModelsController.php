<?php

namespace App\Http\Controllers;


use App\Models\DataModel;
use Illuminate\Http\Request;

use App\Jobs\GenerateModelResult;

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
        $this->dispatch(new GenerateModelResult($modelId, $modelVid));

        return redirect(route('data-models.index'));
    }

}
