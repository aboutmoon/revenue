<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;

class ItemsController extends Controller
{
    //
    public function index()
    {
        $items = Item::with('criterias')->get();
        return view('items.index', compact('items'));
    }
}
