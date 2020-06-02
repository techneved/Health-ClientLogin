<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;
use Illuminate\Support\Str;
use Techneved\Client\Models\Client;

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

$factory->define(Client::class, function (Faker $faker) {
    $gender = $faker->randomElement(['male', 'female']);
    $mobile = $faker->numberBetween(1000000000,2147483647);
    return [
        'first_name' => $faker->firstName(),
        'last_name' => $faker->lastName,
        'mobile' => $mobile,
        'mobile_verified_at' => now(),
        'email' => $faker->unique()->safeEmail,
        'email_verified_at' => now(),
        'password' => bcrypt('password'),
        'gender' => $gender,
        'dob' => $faker->date,
        'age' => $faker->rand(1,100),
        'remember_token' => Str::random(10)
    ];
});