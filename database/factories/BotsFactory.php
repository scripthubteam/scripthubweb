<?php

use Faker\Generator as Faker;

$factory->define(App\Bots::class, function (Faker $faker) {
    $owner = factory(App\ScriptHubUsers::class)->create();
    return [
        'id' => $faker->randomNumber(9),
        'name' => $faker->userName,
        'requested_at' => $faker->dateTimeThisDecade,
        'prefix' => str_random(4),
        'info' => $faker->boolean(50) ? $faker->sentences(3, true) : null,
        'validated' => $faker->boolean(50),
        'discord_users_id' => factory(App\DiscordUsers::class)->create()->id,
        'scripthub_users_id' => $owner->id,
        'scripthub_users_discord_users_id' => $owner->discord_user->id,
    ];
});
