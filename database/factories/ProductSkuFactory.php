<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\ProductSku;
use Faker\Generator as Faker;

$factory->define(ProductSku::class, function (Faker $faker) {

    return [
        'sku_string' => '{"color":"黑色","尺寸"：“3.5”，重量："20kg"}',
        'stock' => random_int(200,500),
        'price' => $faker->randomFloat(2,200,5000),

        'created_at' => $faker->dateTimeBetween('-3 months','-1 months'),
        'updated_at' => $faker->dateTimeBetween('-1 months'),
    ];
});
