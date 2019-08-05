<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;

$factory->define(App\Model\Department::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'created_at' => now()
    ];
});
