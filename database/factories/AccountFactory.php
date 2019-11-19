<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;

$factory->define(App\Models\Account::class, function (Faker $faker) {
    $date_time = $faker->date . '' . $faker->time;
    return [
        'created_at' => $date_time,
        'updated_at' => $date_time,
    ];
});
