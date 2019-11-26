<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Criteria extends Model
{
    public function item()
    {
        return $this->belongsTo('App\Models\Item', 'item_id');
    }

    public function parent()
    {
        return $this->hasOne('App\Models\Criteria', 'parent_id');
    }
}
