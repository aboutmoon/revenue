<?php

namespace App\Imports;

use App\Models\Location;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class LocationsImport implements ToCollection, WithHeadingRow
{
    public function collection(Collection $collection)
    {
        //market
        foreach ($collection as $row) {
            $market = Location::firstOrCreate(['name' => trim($row['market']), 'level_type' => 'Market', 'parent_id' => 1]);


//            $region = Location::firstOrCreate(['name' => $row['region'], 'level_type' => 'Region', 'parent_id' => $market->id]);



//            $sub_region = Location::firstOrCreate(['name' => $row['subregion'], 'level_type' => 'Sub Region', 'parent_id' => $region->id]);


            $country = Location::firstOrCreate(['name' => $row['country'], 'level_type' => 'Country', 'parent_id' => $market->id, 'region' => $row['region'], 'sub_region' => isset($row['subregion'])? $row['subregion']: '']);

        }

    }
}
