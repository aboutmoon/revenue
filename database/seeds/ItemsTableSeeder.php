<?php

use Illuminate\Database\Seeder;
use App\Models\Item;
use App\Imports\ItemsImport;
use Maatwebsite\Excel\Facades\Excel;

class ItemsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
//        $world = Item::create(['name'=> 'World', 'level_type'=>'World','parent_id'=> 0]);
        $path = storage_path('app/public/item-parameters.csv');
        Excel::import(new ItemsImport, $path);
    }
}
