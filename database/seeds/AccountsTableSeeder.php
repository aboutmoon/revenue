<?php

use Illuminate\Database\Seeder;
use App\Models\Account;
use App\Imports\AccountsImport;
use Maatwebsite\Excel\Facades\Excel;

class AccountsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //all
        $rootAccount = Account::create(['name'=> 'All', 'level_type'=>'All','parent_id'=> 0]);

        $path = storage_path('app/public/forecast.csv');
        Excel::import(new AccountsImport, $path);
    }
}
