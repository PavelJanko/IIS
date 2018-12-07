<?php

use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

function nullableColumn($fakerProperty) {
    return rand(0, 1) ? $fakerProperty : null;
}

$factory->define(App\Employee::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'username' => $faker->unique()->userName,
        'email' => $faker->unique()->safeEmail,
        'password' => '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm',
        'phone_number' => nullableColumn($faker->bothify('#########')),
        'street' => nullableColumn($faker->streetName),
        'building_number' => nullableColumn($faker->buildingNumber),
        'city' => nullableColumn($faker->city),
        'zip_code' => nullableColumn($faker->bothify('#####')),
        'remember_token' => str_random(10),
        'created_at' => $faker->dateTimeBetween('-15 days', '+15 days')
    ];
});
