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
        'fk_discord_users' => factory(App\DiscordUsers::class)->create()->id,
        'fk_scripthub_users' => $owner->id,
        'fk_scripthub_users_discord_users' => $owner->discord_user->id,
    ];
});
