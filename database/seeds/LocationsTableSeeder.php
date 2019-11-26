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
        $path = storage_path('app/public/share_country.csv');
        Excel::import(new LocationsImport, $path);

    }
}
