<?php

use Illuminate\Database\Seeder;
use App\Models\Account;

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
        $rootAccount = App\Models\Account::create(['name'=> 'All', 'level_type'=>'all','parent_id'=> 0]);

        //category
        $oemAccount = App\Models\Account::create(['name'=> 'OEM', 'level_type'=>'category','parent_id'=> $rootAccount->id]);
        $odmAccount = App\Models\Account::create(['name'=> 'ODM', 'level_type'=>'category','parent_id'=> $rootAccount->id]);

        //account
        App\Models\Account::create(['name'=> 'DORO', 'level_type'=>'category','parent_id'=> $oemAccount->id]);
        App\Models\Account::create(['name'=> 'TCL', 'level_type'=>'category','parent_id'=> $oemAccount->id]);
        App\Models\Account::create(['name'=> 'TRANSSION', 'level_type'=>'category','parent_id'=> $oemAccount->id]);

        App\Models\Account::create(['name'=> 'NOKIA', 'level_type'=>'category','parent_id'=> $odmAccount->id]);
        App\Models\Account::create(['name'=> 'SAMSUNG', 'level_type'=>'category','parent_id'=> $odmAccount->id]);

    }
}
