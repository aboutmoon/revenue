<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ForecastItemsView extends Model
{
    protected $table = 'forecast_items_view';
    protected $fillable = ['model_id', 'model_vid', 'location_id', 'account_id','item_id', 'date', 'coverage'];
}
