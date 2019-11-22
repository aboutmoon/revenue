<?php

use Illuminate\Database\Seeder;
use App\Models\ForecastItem;

class ForecastItemTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ForecastItem::create(['model_id' => 1, 'model_vid' => 1, 'fi_location_id' => 7, 'fi_account_id' => 7, 'fi_item_id' => 1, 'date_from_id' => 1, 'date_to_id' => 1, 'coverage' => 14543.234]);
        ForecastItem::create(['model_id' => 1, 'model_vid' => 1, 'fi_location_id' => 8, 'fi_account_id' => 7, 'fi_item_id' => 1, 'date_from_id' => 1, 'date_to_id' => 1, 'coverage' => 14543.234]);
        ForecastItem::create(['model_id' => 1, 'model_vid' => 1, 'fi_location_id' => 9, 'fi_account_id' => 7, 'fi_item_id' => 1, 'date_from_id' => 1, 'date_to_id' => 1, 'coverage' => 14543.234]);
        ForecastItem::create(['model_id' => 1, 'model_vid' => 1, 'fi_location_id' => 10, 'fi_account_id' => 5, 'fi_item_id' => 1, 'date_from_id' => 1, 'date_to_id' => 1, 'coverage' => 14543.234]);
        ForecastItem::create(['model_id' => 1, 'model_vid' => 1, 'fi_location_id' => 10, 'fi_account_id' => 6, 'fi_item_id' => 1, 'date_from_id' => 1, 'date_to_id' => 1, 'coverage' => 14543.234]);
        ForecastItem::create(['model_id' => 1, 'model_vid' => 1, 'fi_location_id' => 10, 'fi_account_id' => 9, 'fi_item_id' => 1, 'date_from_id' => 1, 'date_to_id' => 1, 'coverage' => 14543.234]);
        ForecastItem::create(['model_id' => 1, 'model_vid' => 1, 'fi_location_id' => 10, 'fi_account_id' => 9, 'fi_item_id' => 2, 'date_from_id' => 1, 'date_to_id' => 1, 'coverage' => 14543.234]);
        ForecastItem::create(['model_id' => 1, 'model_vid' => 1, 'fi_location_id' => 10, 'fi_account_id' => 9, 'fi_item_id' => 3, 'date_from_id' => 1, 'date_to_id' => 1, 'coverage' => 14543.234]);
    }
}
