<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ForecastCriteria extends Model
{
    protected $table = 'forecast_criterias';

    public function item()
    {
        return $this->hasOne('App\Model\Item', 'id', 'item_id');
    }

    public function accounts()
    {
        return $this->hasManyThrough(
            'App\Models\Account',
            'App\Models\ForecastCriteriaAccount',
            'id',
            'id',
            'id',
            'account_id');
    }

    public function locations()
    {
        return $this->hasManyThrough(
            'App\Models\Location',
            'App\Models\ForecastCriteriaLocation',
            'id',
            'id',
            'id',
            'location_id'
        );
    }
}
