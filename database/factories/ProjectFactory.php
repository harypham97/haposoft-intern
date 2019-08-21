<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(App\Models\Project::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'description' => $faker->text,
        'customer_id' => App\Models\Customer::all()->random()->id,
        'date_start' => now(),
        'date_finish' => now()
    ];
});
