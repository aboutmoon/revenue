<?php

use Illuminate\Database\Seeder;
use App\Models\Item;

class ItemsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Item::create(['name'=> 'FOTA', 'type'=>'type1']);
        Item::create(['name'=> 'Native apps', 'type'=>'type2']);
        Item::create(['name'=> 'Store', 'type'=>'type3']);
        Item::create(['name'=> 'PRELOAD', 'type'=>'type3']);
        Item::create(['name'=> 'Royalties', 'type'=>'type3']);
    }
}
