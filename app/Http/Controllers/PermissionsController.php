<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

class PermissionsController extends Controller
{
    //
    public function index(Request $request) {
        $permissions = Permission::all();
//        dd($permissions);
        return view('pages.permissions.index', compact('permissions'));
    }
}
