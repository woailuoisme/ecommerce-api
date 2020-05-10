<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Product;
use Faker\Generator as Faker;

$sku_attr = \App\Models\SkuKey::with('skuValues')->get();
$sku_options = $sku_attr->map(function ($key) {
    return [
        'name'   => $key->name,
        'key'    => $key->key,
        'values' => $key->skuValues->map(function ($value) {
            return $value->value;
        })->random(2)->toArray(),
    ];
});
$sku_array = $sku_options->toArray();
//dd($sku_array);

$factory->define(Product::class, function (Faker $faker) use ($sku_array) {

    return [
        'title'          => $faker->sentence(4, true),
        'description'    => $faker->paragraphs(2, true),
        'content'        => $faker->paragraphs(5, true),
        'attribute_list' => \App\Helpers\Util::json_encode($sku_array),

        'image'        => $faker->imageUrl(),
        'is_sale'      => $faker->boolean(),
        'rating'       => random_int(4, 5),
        'sold_count'   => random_int(1000, 5000),
        'review_count' => random_int(100, 1000),

        'price'      => $faker->randomFloat(3, 100, 1100),
        'created_at' => $faker->dateTimeBetween('-3 months', '-1 months'),
        'updated_at' => $faker->dateTimeBetween('-1 months'),
    ];
});
