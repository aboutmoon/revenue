<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    public $timestamps = false;

    public function parent()
    {
        return $this->hasOne('App\Models\Account', 'id', 'parent_id');
    }
}
