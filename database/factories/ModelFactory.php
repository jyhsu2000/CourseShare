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

$factory->define(App\User::class, function (Faker\Generator $faker) {
    static $password;

    $isConfirmed = $faker->boolean();

    return [
        'name'           => $faker->name,
        'email'          => $faker->safeEmail,
        'password'       => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
        'confirm_code'   => $isConfirmed ? null : str_random(60),
        'confirm_at'     => $isConfirmed ? $faker->dateTime : null,
        'register_at'    => $faker->dateTime,
        'register_ip'    => $faker->ipv4,
        'last_login_at'  => $faker->dateTime,
        'last_login_ip'  => $faker->ipv4,
    ];
});

$factory->define(App\Teacher::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
    ];
});
