<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Criteria extends Model
{
    public function item()
    {
        return $this->belongsTo('App\Models\Item', 'item_id');
    }
}