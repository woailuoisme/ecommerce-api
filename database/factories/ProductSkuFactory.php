<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\ProductSku;
use Faker\Generator as Faker;


$factory->define(ProductSku::class, function (Faker $faker) {

    return [
//        'sku_json' => \App\Helpers\Util::json_encode($sku_collection->toArray()),
//        'sku_str' => $sku_str,
        'stock' => random_int(200, 500),
        'price' => $faker->randomFloat(2, 200, 5000),

        'created_at' => $faker->dateTimeBetween('-3 months', '-1 months'),
        'updated_at' => $faker->dateTimeBetween('-1 months'),
    ];
});
