<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    public $timestamps = false;
    public $guarded = ['id'];

    public function oem()
    {
        return $this->hasOne('App\Models\Account', 'id', 'oem_id');
    }

    public function odm()
    {
        return $this->hasOne('App\Models\Account', 'id', 'odm_id');
    }

    public function carrier()
    {
        return $this->hasOne('App\Models\Account', 'id', 'carrier_id');
    }

    public function type()
    {
        return $this->hasOne('App\Models\Type', 'id', 'type_id');
    }

    public function Licensee()
    {
        return $this->hasOne('App\Models\Licensee', 'id', 'licensee_id');
    }
}
