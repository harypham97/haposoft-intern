<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;

$factory->define(App\Models\Report::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'description' => $faker->text,
        'user_id' => App\Models\User::all()->random()->id
    ];
});
