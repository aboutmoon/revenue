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
        $carrierAccount = App\Models\Account::create(['name'=> 'CARRIER', 'level_type'=>'category','parent_id'=> $rootAccount->id]);

        //account
        App\Models\Account::create(['name'=> 'OEM_1', 'level_type'=>'category','parent_id'=> $oemAccount->id]);
        App\Models\Account::create(['name'=> 'OEM_2', 'level_type'=>'category','parent_id'=> $oemAccount->id]);
        App\Models\Account::create(['name'=> 'OEM_3', 'level_type'=>'category','parent_id'=> $oemAccount->id]);

        App\Models\Account::create(['name'=> 'ODM_1', 'level_type'=>'category','parent_id'=> $odmAccount->id]);
        App\Models\Account::create(['name'=> 'ODM_2', 'level_type'=>'category','parent_id'=> $odmAccount->id]);
        App\Models\Account::create(['name'=> 'ODM_3', 'level_type'=>'category','parent_id'=> $odmAccount->id]);

        App\Models\Account::create(['name'=> 'CARRIER_1', 'level_type'=>'category','parent_id'=> $carrierAccount->id]);
        App\Models\Account::create(['name'=> 'CARRIER_2', 'level_type'=>'category','parent_id'=> $carrierAccount->id]);



    }
}
