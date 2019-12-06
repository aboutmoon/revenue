<?php

use Illuminate\Database\Seeder;
use App\Imports\ForecastDevicesImport;


class ForecastDevicesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $path = storage_path('app/public/forecast-devices.csv');
        Excel::import(new ForecastDevicesImport, $path);

    }
}
