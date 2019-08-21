<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models;
use Faker\Generator as Faker;

$factory->define(App\Models\Admin::class, function (Faker $faker) {
    return [
        'email' => $faker->unique()->safeEmail,
        'password' => '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm',// secret
        'remember_token' => Str::random(10),
        'name' => $faker->name,
    ];
});
