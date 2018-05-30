<?php

use Faker\Generator as Faker;
use Modules\Cryptocurrency\Entities\Cryptocurrency;

$factory->define(Cryptocurrency::class, function (Faker $faker) {
	static $rank = 1;

    return [
        'name' => $faker->name,
        'symbol' => $faker->lexify('?????'), // secret
        'logo' => null,
        'rank' => $rank++,
        'price_usd' => $faker->randomFloat(8, 0, 99999999),
        'price_btc' => $faker->randomFloat(8, 0, 1),
        '24h_volume_usd' => $faker->numberBetween(1000, 100000),
        'market_cap_usd' => $faker->numberBetween(1000, 100000),
        'available_supply' => $faker->numberBetween(1000, 100000),
        'total_supply' => $faker->numberBetween(1000, 100000),
        'percent_change_1h' => $faker->randomFloat(8, -100, 100),
        'percent_change_24h' => $faker->randomFloat(8, -100, 100),
        'percent_change_7d' => $faker->randomFloat(8, -100, 100),
    ];
});
