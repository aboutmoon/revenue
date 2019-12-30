<?php

use Illuminate\Database\Seeder;

use App\Imports\ProjectsImport;

//$table->bigIncrements('id');
//$table->bigInteger('carrier_id');
//$table->bigInteger('oem_id');
//$table->bigInteger('odm_id');
//$table->string('model_name');
//$table->string('type');
//$table->integer('financing');
//$table->timestamps();
class ProjectsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $path = storage_path('app/public/shipment-forecast.csv');
        Excel::import(new ProjectsImport, $path);

    }
}
