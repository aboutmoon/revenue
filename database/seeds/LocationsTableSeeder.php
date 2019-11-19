<?php

use Illuminate\Database\Seeder;
use App\Models\Location;

class LocationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $global = Location::create(['name'=> 'Global', 'level_type'=>'global','parent_id'=> 0]);


        //market
        $developed = Location::create(['name'=> 'Developped Markets', 'level_type'=>'market','parent_id'=> $global->id]);
        $developing = Location::create(['name'=> 'Developping Markets', 'level_type'=>'market','parent_id'=> $global->id]);

        //region
        $northAmerica = Location::create(['name'=> 'North America', 'level_type'=>'region','parent_id'=> $developed->id]);
        $asia = Location::create(['name'=> 'Asia', 'level_type'=>'region','parent_id'=> $developing->id]);
        $africa = Location::create(['name'=> 'Africa', 'level_type'=>'region','parent_id'=> $developing->id]);

        //country
        Location::create(['name'=> 'America', 'level_type'=>'country','parent_id'=> $northAmerica->id]);
        Location::create(['name'=> 'China', 'level_type'=>'country','parent_id'=> $asia->id]);
        Location::create(['name'=> 'India', 'level_type'=>'country','parent_id'=> $asia->id]);
        Location::create(['name'=> 'Zimbabwe', 'level_type'=>'country','parent_id'=> $africa->id]);
        Location::create(['name'=> 'Zambia', 'level_type'=>'country','parent_id'=> $africa->id]);

    }
}
