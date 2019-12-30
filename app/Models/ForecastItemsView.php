<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ForecastItemsView extends Model
{
    public $timestamps = false;
    protected $table = 'forecast_items_view';
    protected $fillable = ['model_id', 'model_vid', 'location_id', 'project_id','item_id', 'date', 'coverage', 'date_from'];
}
