<?php

use Faker\Generator as Faker;

$factory->define(App\TempRegistration::class, function (Faker $faker) {
    $discord_user = factory(App\DiscordUsers::class)->create();
    return [
        'hash_code' => Hash::make($discord_user->id . $discord_user->username),
        'discord_users_id' => $discord_user->id,
    ];
});
