<?php

use Faker\Generator as Faker;

$factory->define(App\Department::class, function (Faker $faker) {
    return [
        'shortcut' => strtoupper($faker->lexify()),
        'name' => $faker->sentence(4),
    ];
});
