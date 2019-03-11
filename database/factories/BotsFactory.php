<?php

use Faker\Generator as Faker;

$factory->define(App\Bots::class, function (Faker $faker) {
    $owner = factory(App\ScriptHubUsers::class)->create();
    return [
        'id' => $faker->randomNumber(9),
        'name' => $faker->userName,
        'requested_at' => $faker->dateTimeThisDecade,
        'prefix' => str_random(random_int(1, 5)),
        'info' => $faker->boolean(50) ? $faker->sentences(3, true) : null,
        'avatar_url' => $faker->boolean(50) ? $faker->imageUrl : null,
        'validated' => $faker->boolean(50),
        'popularity' => random_int(0, 43),
        'fk_scripthub_users' => $owner->id,
        'fk_scripthub_users_discord_users' => $owner->discord_user->id,
    ];
});
