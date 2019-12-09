<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ForecastDevicesView extends Model
{
    protected $table = 'forecast_devices_view';
    protected $fillable = ['model_id', 'model_vid', 'project', 'carrier_id', 'oem_id', 'odm_id', 'project_name', 'connectivity', 'brand', 'licensee', 'type', 'location_id', 'date', 'quantity'];

}
