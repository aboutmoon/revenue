<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Location;

class LocationsController extends Controller
{
    public function index(Request $request)
    {
        $locations = Location::all();
        return view('locations.index', compact('locations'));
    }
}
