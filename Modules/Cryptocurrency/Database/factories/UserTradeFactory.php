<?php

use Faker\Generator as Faker;
use Modules\Cryptocurrency\Entities\UserTrade;

$factory->define(UserTrade::class, function (Faker $faker) {
    return [
        'amount' => $faker->randomFloat(8, 0, 99999999),
        'price_usd' => $faker->randomFloat(8, 0, 99999999),
        'notes' => $faker->text(255),
        'traded_at' => $faker->dateTimeBetween('-2 years', 'now'),
    ];
});
