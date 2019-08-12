<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Illuminate\Support\Str;
use Faker\Generator as Faker;

$factory->define(App\Model\Task::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'description' => $faker->text,
        'hour' => $faker->numberBetween(1,8),
        'user_id' => App\Model\User::all()->random()->id,
        'project_id' => App\Model\Project::all()->random()->id
    ];
});
