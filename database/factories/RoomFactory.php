<?php

use Faker\Generator as Faker;

$factory->define(App\Room::class, function (Faker $faker) {
    return [
        'department_id' => $faker->numberBetween(1, \App\Department::count()),
        'label' => ucfirst($faker->unique()->bothify('?###')),
        'is_in_cvt' => $faker->boolean,
    ];
});
