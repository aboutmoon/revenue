<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Criteria;

class CriteriaController extends Controller
{
    public function index(Request $request)
    {
        $criterias = Criteria::with('item')->get();
        return view('criterias.index', compact('criterias'));
    }
}
