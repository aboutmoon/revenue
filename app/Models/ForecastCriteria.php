<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ForecastCriteria extends Model
{
    protected $table = 'forecast_criterias';

    protected $fillable = ['model_id', 'model_vid', 'item_id', 'oem_id', 'odm_id', 'carrier_id'];

    public function oem()
    {
        return $this->hasOne('App\Models\Account', 'id', 'oem_id');
    }

    public function odm()
    {
        return $this->hasOne('App\Models\Account', 'id', 'odm_id');
    }

    public function carrier()
    {
        return $this->hasOne('App\Models\Account', 'id', 'carrier_id');
    }

    public function item()
    {
        return $this->hasOne('App\Models\Item', 'id', 'item_id');
    }

    public function parameters()
    {
        return $this->hasMany('App\Models\ForecastCriteriaParameter', 'forecast_criteria_id', 'id');
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
