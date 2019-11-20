<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;

class ProjectsController extends Controller
{
    public function index(Request $request)
    {
        $projects = Project::with(['oem', 'odm', 'carrier'])->get();
        return view('projects.index', compact('projects'));
    }
}
