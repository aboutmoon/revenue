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
        $forecastItem = ForecastItem::create(['model_id' => 1, 'model_vid' => 1, 'date_from' => date('Y-m-d H:i:s'), 'date_to' => date('Y-m-d H:i:s'), 'coverage' => 0.12, 'monthly_growth' => 0.22]);
        $forecastItem2 = ForecastItem::create(['model_id' => 1, 'model_vid' => 1, 'date_from' => date('Y-m-d H:i:s'), 'date_to' => date('Y-m-d H:i:s'), 'coverage' => 0.12, 'monthly_growth' => 0.22]);
        $forecastItem3 = ForecastItem::create(['model_id' => 1, 'model_vid' => 1, 'date_from' => date('Y-m-d H:i:s'), 'date_to' => date('Y-m-d H:i:s'), 'coverage' => 0.12, 'monthly_growth' => 0.22]);
        ForecastItemItem::create(['id' => $forecastItem->id, 'item_id' => 2]);
        ForecastItemItem::create(['id' => $forecastItem->id, 'item_id' => 3]);
        ForecastItemItem::create(['id' => $forecastItem->id, 'item_id' => 4]);

        ForecastItemItem::create(['id' => $forecastItem2->id, 'item_id' => 2]);
        ForecastItemItem::create(['id' => $forecastItem2->id, 'item_id' => 3]);
        ForecastItemItem::create(['id' => $forecastItem2->id, 'item_id' => 4]);

        ForecastItemItem::create(['id' => $forecastItem3->id, 'item_id' => 2]);
        ForecastItemItem::create(['id' => $forecastItem3->id, 'item_id' => 3]);
        ForecastItemItem::create(['id' => $forecastItem3->id, 'item_id' => 4]);

        ForecastItemAccount::create(['id' => $forecastItem->id, 'account_id' => 7]);
        ForecastItemAccount::create(['id' => $forecastItem->id, 'account_id' => 8]);
        ForecastItemAccount::create(['id' => $forecastItem->id, 'account_id' => 9]);
        ForecastItemAccount::create(['id' => $forecastItem->id, 'account_id' => 10]);
        ForecastItemAccount::create(['id' => $forecastItem->id, 'account_id' => 11]);
        ForecastItemAccount::create(['id' => $forecastItem->id, 'account_id' => 12]);

        ForecastItemAccount::create(['id' => $forecastItem2->id, 'account_id' => 7]);
        ForecastItemAccount::create(['id' => $forecastItem2->id, 'account_id' => 8]);
        ForecastItemAccount::create(['id' => $forecastItem2->id, 'account_id' => 9]);
        ForecastItemAccount::create(['id' => $forecastItem2->id, 'account_id' => 10]);
        ForecastItemAccount::create(['id' => $forecastItem2->id, 'account_id' => 11]);
        ForecastItemAccount::create(['id' => $forecastItem2->id, 'account_id' => 12]);

        ForecastItemAccount::create(['id' => $forecastItem3->id, 'account_id' => 7]);
        ForecastItemAccount::create(['id' => $forecastItem3->id, 'account_id' => 8]);
        ForecastItemAccount::create(['id' => $forecastItem3->id, 'account_id' => 9]);
        ForecastItemAccount::create(['id' => $forecastItem3->id, 'account_id' => 10]);
        ForecastItemAccount::create(['id' => $forecastItem3->id, 'account_id' => 11]);
        ForecastItemAccount::create(['id' => $forecastItem3->id, 'account_id' => 12]);

        ForecastItemLocation::create(['id' => $forecastItem->id, 'location_id' => 209]);
        ForecastItemLocation::create(['id' => $forecastItem->id, 'location_id' => 210]);
        ForecastItemLocation::create(['id' => $forecastItem->id, 'location_id' => 211]);
        ForecastItemLocation::create(['id' => $forecastItem->id, 'location_id' => 212]);
        ForecastItemLocation::create(['id' => $forecastItem->id, 'location_id' => 213]);

        ForecastItemLocation::create(['id' => $forecastItem2->id, 'location_id' => 209]);
        ForecastItemLocation::create(['id' => $forecastItem2->id, 'location_id' => 210]);
        ForecastItemLocation::create(['id' => $forecastItem2->id, 'location_id' => 211]);
        ForecastItemLocation::create(['id' => $forecastItem2->id, 'location_id' => 212]);
        ForecastItemLocation::create(['id' => $forecastItem2->id, 'location_id' => 213]);
    }
}
