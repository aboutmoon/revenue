<?php

use Illuminate\Database\Seeder;
use App\Models\ForecastDevice;
use App\Models\Location;
use App\Models\Account;
use App\Models\Project;

class ForecastDevicesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $locations = Location::where('level_type', 'Market')->get();
        $projects = Project::all();
        foreach ($locations as $location) {
            foreach ($projects as $project) {
                ForecastDevice::create([
                    'model_id' => 1,
                    'model_vid' => 1,
                    'project_id' => $project->id,
                    'location_id' => $location->id,
                    'date_from' => '2019-01-01',
                    'date_to' => '2020-01-01',
                    'quantity' => 24000
                    ]);
            }
        }

    }
}
