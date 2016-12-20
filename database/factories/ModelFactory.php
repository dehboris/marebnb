<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\User::class, function (Faker\Generator $faker) {
    $faker = Faker\Factory::create('hr_HR');

    return [
        'first_name' => $faker->firstName,
        'last_name'  => $faker->lastName,
        'email'      => $faker->unique()->safeEmail,
        'password'   => 'password',
        'street'     => $faker->streetAddress,
        'country'    => 'Hrvatska',
        'city'       => $faker->city,
        'zip'        => $faker->numberBetween(1, 20000),
        'phone'      => $faker->e164PhoneNumber,
        'api_token'  => str_random(60)
    ];
});

$factory->define(App\Room::class, function (Faker\Generator $faker) {
    $people = $faker->numberBetween(1, 5);

    return [
        'label'      => $faker->sentence,
        'price'      => $faker->numberBetween(10, 50),
        'min_people' => $people,
        'max_people' => $people + $faker->numberBetween(1, 5),
        'seaside'    => $faker->boolean,
    ];
});

