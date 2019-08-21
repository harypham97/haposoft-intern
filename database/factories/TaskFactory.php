<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Illuminate\Support\Str;
use Faker\Generator as Faker;

$factory->define(App\Models\Task::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'description' => $faker->text,
        'hour' => $faker->numberBetween(1,8),
        'user_id' => App\Models\User::all()->random()->id,
        'project_id' => App\Models\Project::all()->random()->id
    ];
});
