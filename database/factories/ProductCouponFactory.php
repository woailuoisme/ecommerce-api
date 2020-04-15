<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\ProductCoupon;
use Faker\Generator as Faker;

$factory->define(ProductCoupon::class, function (Faker $faker) {
    $start_at = $faker->dateTimeBetween('-3 months','-1 months');
    $expires_at = (clone $start_at)->modify('+10 days');

    return [

        'name' => $faker->word(2),
        'code' => $faker->uuid(),
        'description' => $faker->paragraph(),
        'type' => $faker->randomElement(['general','present8','present9']),
        'value' => $faker->randomFloat(2,0.8,1),
        'total' => $faker->randomFloat(2,1000,9999),
        'used' => $faker->randomElement([1,2]),
        'min_amount' => $faker->randomFloat(2,1000,1200),
        'start_at' => $start_at,
        'expires_at' =>  $expires_at,
        'is_active' => $faker->boolean(),
        'created_at' => $faker->dateTimeBetween('-3 months','-1 months'),
        'updated_at' => $faker->dateTimeBetween('-1 months'),
    ];
});
