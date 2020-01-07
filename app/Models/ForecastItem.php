<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
class ForecastItem extends Model
{

    protected $table = 'forecast_items';

    protected $guarded = ['id','locations', 'items'];
    public function model()
    {
        return $this->belongsTo('App\Models\DataModel', 'id', 'model_id');
    }

    public function oem()
    {
        return $this->hasOne('App\Models\Account', 'id', 'oem_id');
    }

    public function odm()
    {
        return $this->hasOne('App\Models\Account', 'id', 'odm_id');
    }

    public function licensee()
    {
        return $this->hasOne('App\Models\Licensee', 'id', 'licensee_id');
    }

    public function type()
    {
        return $this->hasOne('App\Models\Type', 'id', 'type_id');
    }

    public function carrier()
    {
        return $this->hasOne('App\Models\Account', 'id', 'carrier_id');
    }

//    public function accounts()
//    {
//        return $this->hasManyThrough(
//            'App\Models\Account',
//            'App\Models\ForecastItemAccount',
//            'id',
//            'id',
//            'id',
//            'account_id');
//    }

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
