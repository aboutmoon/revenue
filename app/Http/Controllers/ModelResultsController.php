<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ModelResult;
use Illuminate\Support\Facades\DB;

class ModelResultsController extends Controller
{
    public function index(Request $request)
    {
        $modelId = $request->get('model_id');
        $modelVid = $request->get('model_vid');

        $modelResults = DB::table('model_results')
            ->select(
                'oem.name as OEM',
                'odm.name as ODM',
                'projects.type as Type',
                'carrier.name as Carrier',
                'l1.name as Country',
                'l2.name as Market',
                'items.name as Item',
                'model_results.date as Date',
                'model_results.result as Value',
            )
            ->join('projects', 'model_results.project_id', '=', 'projects.id')
            ->join('locations as l1', 'model_results.location_id', '=', 'l1.id')
            ->join('locations as l2', 'l1.parent_id', '=', 'l2.id')
            ->join('items', 'model_results.item_id', '=', 'items.id')
            ->leftJoin('accounts as oem', 'projects.oem_id', '=', 'oem.id')
            ->leftJoin('accounts as odm', 'projects.odm_id', '=', 'odm.id')
            ->leftJoin('accounts as carrier', 'projects.carrier_id', '=', 'carrier.id')
            ->where('model_id', $modelId)
            ->where('model_vid', $modelVid)->get();

        $modelResults = json_encode($modelResults);
        return view('model-results.index', compact('modelResults'));
    }
}
