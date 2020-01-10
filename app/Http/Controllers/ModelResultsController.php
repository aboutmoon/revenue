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
                'types.name as Type',
                'licensees.name as Licensee',
                'carrier.name as Carrier',
                'l1.name as Country',
                'l2.name as Market',
                'i1.name as Item',
                'i2.name as Category',
                'model_results.date as Date',
                'model_results.result as Value'
            )
            ->join('projects', 'model_results.project_id', '=', 'projects.id')
            ->join('locations as l1', 'model_results.location_id', '=', 'l1.id')
            ->join('locations as l2', 'l1.parent_id', '=', 'l2.id')
            ->join('items as i1', 'model_results.item_id', '=', 'i1.id')
            ->join('items as i2', 'i1.parent_id', '=', 'i2.id')
            ->leftJoin('accounts as oem', 'projects.oem_id', '=', 'oem.id')
            ->leftJoin('accounts as odm', 'projects.odm_id', '=', 'odm.id')
            ->leftJoin('accounts as carrier', 'projects.carrier_id', '=', 'carrier.id')
            ->leftJoin('licensees', 'projects.licensee_id', '=', 'licensees.id')
            ->leftJoin('types', 'projects.type_id', '=', 'types.id')
            ->where('model_results.model_id', $modelId)
            ->where('model_results.model_vid', $modelVid)->get();

        $modelResults = json_encode($modelResults);
        return view('model-results.index', compact('modelResults'));
    }
}
