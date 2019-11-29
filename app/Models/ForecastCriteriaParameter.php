<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ForecastCriteriaParameter extends Model
{
    protected $table = 'forecast_criteria_parameters';

    protected $fillable = ['forecast_criteria_id', 'criteria_id', 'value', 'monthly_growth', 'date_from', 'date_to'];

    public function criteria()
    {
        return $this->hasOne('App\Models\Criteria', 'id', 'criteria_id');
    }
}
