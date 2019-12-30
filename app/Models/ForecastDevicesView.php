<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ForecastDevicesView extends Model
{
    public $timestamps = false;
    protected $table = 'forecast_devices_view';
    protected $guarded = ['id'];

    public function project(){
        return $this->hasOne('App\Models\Project', 'id', 'project_id');
    }

    public function location(){
        return $this->hasOne('App\Models\Location', 'id', 'location_id');
    }

    public function market_id(){
        return $this->hasOne('App\Models\Location', 'id', 'market_id');
    }
}
