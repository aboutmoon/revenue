<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ForecastItemAccount extends Model
{
    protected $table = 'forecast_item_accounts';

    protected $fillable = ['id', 'account_id'];
}
