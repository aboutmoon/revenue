<?php

use Illuminate\Database\Seeder;
use App\Models\Location;
use App\Imports\LocationsImport;
use Maatwebsite\Excel\Facades\Excel;

class LocationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $world = Location::create(['name'=> 'World', 'level_type'=>'World','parent_id'=> 0]);
        $globalMarket = Location::create(['name'=> 'Global', 'level_type'=>'Market','parent_id'=> 1]);
        $globalCountry = Location::create(['name'=> 'Global', 'level_type'=>'Country','parent_id'=> $globalMarket->id, 'region' => 'Global', 'sub_region' => 'Global']);
        $path = storage_path('app/public/shipment-forecast.csv');
        Excel::import(new LocationsImport, $path);
    }
}
