<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;

$factory->define(\App\Models\Profile::class, function (Faker $faker) {
    $createdTime = $faker->dateTimeBetween('-3 months');
    $updatedTime = (clone $createdTime)->modify('+5 days');
    $birthday = $faker->dateTimeBetween('-40 years', '-20 years');

//    Carbon::createFro($request->startFrom)->format('d-m-Y H:i:s');
    return [
        'gender'       => $faker->randomElement(['male', 'female']),
        'birthday'     => $birthday->format('Y-m-d H:i:s'),
        'mobile_phone' => $faker->phoneNumber,
        'qq'           => $faker->numberBetween(10000000, 99999999).'',
        'wechat'       => $faker->email,
        'Hobby'        => \App\Helpers\Util::json_encode($faker->randomElements([
            '篮球',
            '足球',
            '看书',
            '睡觉',
            '游泳',
            '户外',
            '游泳',
        ], random_int(2, 4))),
        'descriptions' => $faker->sentences(3, true),
        'created_at'   => $createdTime,
        'updated_at'   => $updatedTime,
    ];
});
