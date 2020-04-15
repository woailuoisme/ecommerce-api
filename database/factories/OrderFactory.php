<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Order;
use Faker\Generator as Faker;

$factory->define(Order::class, function (Faker $faker) {

    return [
        'order_status' =>$faker->randomElement(array_keys(Order::$refundStatusMap)),
        'order_num' =>$faker->uuid,
        'total_amount' =>$faker->randomFloat(2,1000,10000),
        'address' =>$faker->address,
        'remark' =>$faker->sentence(),

        'created_at' => $faker->dateTimeBetween('-3 months','-1 months'),
        'updated_at' => $faker->dateTimeBetween('-1 months'),
    ];
});
