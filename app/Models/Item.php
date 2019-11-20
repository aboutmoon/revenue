<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    public function criterias()
    {
        return $this->hasMany('App\Models\Criteria');
    }
}
