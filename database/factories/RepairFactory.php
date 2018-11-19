<?php

use Faker\Generator as Faker;

$factory->define(App\Repair::class, function (Faker $faker) {
    return [
        'device_id' => $faker->numberBetween(1, \App\Device::count()),
        'claimant_id' => $faker->numberBetween(1, \App\Employee::count()),
        'state' => $faker->randomElement(['Pending', 'Trying to repair', 'Repaired', 'Unable to repair']),
    ];
});
