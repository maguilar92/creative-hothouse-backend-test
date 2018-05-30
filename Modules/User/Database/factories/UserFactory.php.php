<?php

use Faker\Generator as Faker;

$factory->define(Modules\User\Entities\User::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => '$2y$10$Fg5kcs5LSkILj2po.zWEVuq61JWmsTL1mh5aXbnBIAr.KhfMo0JLi', // secret
        'remember_token' => str_random(10),
    ];
});
