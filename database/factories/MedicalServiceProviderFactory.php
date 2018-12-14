<?php

use Faker\Generator as Faker;

$factory->define(App\MedicalServiceProvider::class, function (Faker $faker) {
    return [
        'type' => Rand(0,1),
        'contracted' => Rand(0,1),
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'phone' => $faker->unique()->e164PhoneNumber,
        'status' => Rand(0,4),
    ];
});
