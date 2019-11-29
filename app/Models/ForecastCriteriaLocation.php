<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ForecastCriteriaLocation extends Model
{
    protected $table = 'forecast_criteria_locations';

    protected $fillable = ['id', 'location_id'];
}
