<?php

use Faker\Generator as Faker;

$factory->define(App\Device::class, function (Faker $faker) {
    return [
        'keeper_id' => $faker->numberBetween(1, \App\Employee::count()),
        'serial_number' => $faker->unique()->randomNumber(9),
        'name' => $faker->words(rand(1, 5), true),
        'type' => $faker->randomElement(['PC', 'Laptop', 'Projector', 'Printer', 'Scanner', 'Router']),
        'manufacturer' => $faker->randomElement(['Lenovo', 'Canon', 'LG', 'Samsung', 'Apple', 'Dell']),
    ];
});
