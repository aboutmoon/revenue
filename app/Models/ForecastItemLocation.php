<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ForecastItemLocation extends Model
{
    protected $table = 'forecast_item_locations';

    protected $fillable = ['id', 'location_id'];
}
