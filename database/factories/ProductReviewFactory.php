<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\ProductReview;
use Faker\Generator as Faker;

$factory->define(ProductReview::class, function (Faker $faker) {

    return [
        'content' => $faker->sentence(10),
        'rating' => $faker->randomElement([2,3,4,5]),
        'created_at' => $faker->dateTimeBetween('-3 months','-1 months'),
        'updated_at' => $faker->dateTimeBetween('-1 months'),
    ];
});
