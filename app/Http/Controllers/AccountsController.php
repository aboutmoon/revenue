<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Account;

class AccountsController extends Controller
{
    public function index(Request $request)
    {
        $accounts = Account::all();
        return view('accounts.index', compact('accounts'));
    }
}
