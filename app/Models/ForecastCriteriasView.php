<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ForecastCriteriasView extends Model
{
    protected $table = 'forecast_criterias_view';
    protected $fillable = ['model_id', 'model_vid', 'item_id', 'location_id', 'account_id', 'criteria_id', 'date', 'value'];
}
