<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Product;
use Faker\Generator as Faker;

$factory->define(Product::class, function (Faker $faker) {

    return [

        'title' => $faker->sentence(4, true),
        'description' => $faker->paragraphs(2, true),
        'content' => $faker->paragraphs(5, true),
        'attribute_list'=>'{"color":["黑色","白色"],"尺寸"：[“3.5”,"2.8"]',

        'image' => $faker->imageUrl(),
        'is_sale' => $faker->boolean(),
        'rating' => random_int(4,5),
        'sold_count' => random_int(1000,5000),
        'review_count' => random_int(100,1000),

        'price' => $faker->randomFloat(3,100,1100),
        'created_at' => $faker->dateTimeBetween('-3 months','-1 months'),
        'updated_at' => $faker->dateTimeBetween('-1 months'),
    ];
});
