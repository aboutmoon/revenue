<?php

use Illuminate\Database\Seeder;
use App\Models\ForecastItem;
use App\Models\ForecastItemItem;
use App\Models\ForecastItemAccount;
use App\Models\ForecastItemLocation;
//$table->bigIncrements('id');
//$table->bigInteger('model_id');
//$table->bigInteger('model_vid');
//$table->dateTime('date_from');
//$table->dateTime('date_to');
//$table->decimal('coverage', 24, 8);
//$table->timestamps();
class ForecastItemTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $forecastItem = ForecastItem::create(['model_id' => 1, 'model_vid' => 1, 'date_from' => '2019-1-1', 'date_to' => '2021-12-1', 'coverage' => 0.8, 'monthly_growth' => 0]);

        ForecastItemItem::create(['id' => $forecastItem->id, 'item_id' => 1]);

        ForecastItemAccount::create(['id' => $forecastItem->id, 'account_id' => 7]);

        ForecastItemLocation::create(['id' => $forecastItem->id, 'location_id' => 2]);
        ForecastItemLocation::create(['id' => $forecastItem->id, 'location_id' => 6]);
        ForecastItemLocation::create(['id' => $forecastItem->id, 'location_id' => 44]);
        ForecastItemLocation::create(['id' => $forecastItem->id, 'location_id' => 98]);
    }
}
