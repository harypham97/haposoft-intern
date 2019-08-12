<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(App\Model\User::class, function (Faker $faker) {
    return [
        'email' => $faker->unique()->safeEmail,
        'email_verified_at' => now(),
        'password' => '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm',// secret
        'remember_token' => Str::random(10),
        'name' => $faker->name,
        'dob' => $faker->date(),
        'city' => $faker->city,
        'phone' => $faker->phoneNumber,
        'avatar' => Str::random(10),
        'description' => $faker->text,
        'role_id' => \Config('auth.role_user'),
        'department_id' => $faker->numberBetween(1,10),
        'created_at' => now()
    ];
});
