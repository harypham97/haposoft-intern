<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(App\Models\Customer::class, function (Faker $faker) {
    return [
        'email' => $faker->unique()->safeEmail,
        'password' => '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm',// secret
        'remember_token' => Str::random(10),
        'name' => $faker->name,
        'company' => $faker->company,
        'avatar' => Str::random(10),
        'phone' => $faker->phoneNumber,
        'created_at' => now()
    ];
});
