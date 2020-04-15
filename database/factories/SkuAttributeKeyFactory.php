<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\SkuAttributeKey;
use Faker\Generator as Faker;

$factory->define(SkuAttributeKey::class, function (Faker $faker) {

    return [
        'created_at' => $faker->dateTimeBetween('-3 months','-1 months'),
        'updated_at' => $faker->dateTimeBetween('-1 months'),
    ];
});
