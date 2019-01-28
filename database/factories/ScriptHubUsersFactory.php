<?php

use Faker\Generator as Faker;

$factory->define(App\ScriptHubUsers::class, function (Faker $faker) {
    return [
        'username' => $faker->userName,
        'email' => $faker->unique()->safeEmail,
        'password' => $faker->password,
        'description' => $faker->boolean(50) ? $faker->sentences(3, true) : null,
        'avatar_url' => $faker->boolean(50) ? $faker->imageUrl() : null,
        'discord_users_id' => factory(App\DiscordUsers::class)->create()->id,
    ];
});
