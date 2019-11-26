<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DataModel extends Model
{

    protected $table = 'data_models';

    public function user()
    {
        return $this->hasOne('App\Models\User', 'id', 'author_id');
    }
}
