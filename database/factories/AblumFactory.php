<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Album;
use Faker\Generator as Faker;

$factory->define(Album::class, function (Faker $faker) {

    return [
        'image'      => $faker->imageUrl(),
        'created_at' => $faker->dateTimeBetween('-3 months', '-1 months'),
        'updated_at' => $faker->dateTimeBetween('-1 months'),
    ];
});