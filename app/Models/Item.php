<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{

    public $timestamps = false;

    public function criterias()
    {
        return $this->hasMany('App\Models\Criteria');
    }

    public function parent()
    {
        return $this->hasOne('App\Models\Item', 'id', 'parent_id');
    }
}
