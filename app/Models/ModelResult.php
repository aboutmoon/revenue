<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ModelResult extends Model
{
    protected $table = 'model_results';
    protected $fillable = ['model_id', 'model_vid', 'location_id', 'project_id', 'date', 'item_id', 'result', 'date_from', 'date_to'];

    public function project()
    {
        return $this->hasOne('App\Models\Project', 'id', 'project_id');
    }

    public function location()
    {
        return $this->hasOne('App\Models\Location', 'id', 'location_id');
    }

    public function item()
    {
        return $this->hasOne('App\Models\Item', 'id', 'item_id');
    }
}
