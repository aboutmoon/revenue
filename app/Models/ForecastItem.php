<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
class ForecastItem extends Model
{

    protected $table = 'forecast_items';

    protected $fillable = ['model_id', 'model_vid', 'coverage', 'date_from', 'date_to', 'monthly_growth'];

    public function model()
    {
        return $this->belongsTo('App\Models\DataModel', 'id', 'model_id');
    }

    public function accounts()
    {
        return $this->hasManyThrough(
            'App\Models\Account',
            'App\Models\ForecastItemAccount',
            'id',
            'id',
            'id',
            'account_id');
    }

    public function locations()
    {
        return $this->hasManyThrough(
            'App\Models\Location',
            'App\Models\ForecastItemLocation',
            'id',
            'id',
            'id',
            'location_id'
        );
    }

    public function items()
    {
        return $this->hasManyThrough(
            'App\Models\Item',
            'App\Models\ForecastItemItem',
            'id',
            'id',
            'id',
            'item_id'
        );
    }
}
