<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
//$table->bigIncrements('id');
//$table->bigInteger('model_id');
//$table->bigInteger('model_vid');
//$table->dateTime('date_from');
//$table->dateTime('date_to');
//$table->decimal('coverage', 24, 8);
//$table->timestamps();
class ForecastItem extends Model
{
    protected $table = 'forecast_items';

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
            'App\Models\Location',
            'App\Models\ForecastItemItem',
            'id',
            'id',
            'id',
            'item_id'
        );
    }
}
