<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    public function parent()
    {
        return $this->hasOne('App\Models\Location', 'id', 'parent_id');
    }
}
