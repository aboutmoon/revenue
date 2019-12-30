<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ForecastDevice extends Model
{
    public $timestamps = false;

    protected $table = 'forecast_devices';

    public $guarded = ['id'];
    public function location()
    {
        return $this->hasOne('App\Models\Location', 'id', 'location_id');
    }

    public function project()
    {
        return $this->hasOne('App\Models\Project', 'id', 'project_id');
    }
}
