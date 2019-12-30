<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ForecastCriteriasView extends Model
{
    public $timestamps = false;

    protected $table = 'forecast_criterias_view';
    protected $guarded = ['id'];
}
