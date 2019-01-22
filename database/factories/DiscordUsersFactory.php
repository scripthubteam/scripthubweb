<?php

use Faker\Generator as Faker;

$factory->define(App\DiscordUsers::class, function (Faker $faker) {
    return [
        'id' => $faker->randomNumber(9),
        'nick' => $faker->userName,
        'avatar_url' => $faker->boolean(50) ? $faker->imageUrl : null,
        'created_at' => $faker->dateTimeThisDecade,
    ];
});
