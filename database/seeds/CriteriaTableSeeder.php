<?php

use Illuminate\Database\Seeder;
use App\Models\Item;
use App\Models\Criteria;
use App\Imports\CriteriaImport;

class CriteriaTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $path = storage_path('app/public/Kaios_Business-plan_Parameters.csv');
        Excel::import(new CriteriaImport, $path);
    }
}
