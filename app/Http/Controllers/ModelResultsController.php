<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ModelResult;

class ModelResultsController extends Controller
{
    public function index(Request $request)
    {
        $modelId = $request->get('model_id');
        $modelVid = $request->get('model_vid');

        $modelResults = ModelResult::where('model_id', $modelId)->where('model_vid', $modelVid)->get();
        return view('model-results.index', compact('modelResults'));
    }
}
