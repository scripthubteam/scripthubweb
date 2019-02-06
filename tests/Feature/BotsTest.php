<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

use \App\ScriptHubUsers;

use \Carbon\Carbon;
use App\DiscordUsers;
use App\Bots;

class BotsTest extends TestCase
{

    use RefreshDatabase;
    use WithFaker;

    /**
     * Checks if a Bot can be created.<br>
     * It also checks for incorrect values.
     *
     * @return void
     */
    public function testCreatesBot()
    {
        // Creating User for access
        $user = factory(ScriptHubUsers::class)->create([
            'email_verified_at' => Carbon::now(),
        ]);
        $this->actingAs($user)
             ->get(route('bots.create'))
             ->assertOk();

        $this->setUpFaker();
        // Creating Bot
        $discord_bot = factory(DiscordUsers::class)->create();

        // Redirect because empty
        $this->actingAs($user)
             ->post(route('bots.store'))
             ->assertStatus(302);

        // Declaring input
        $input = [
            'name' => $this->faker->userName,
            'prefix' => str_random(random_int(1, 5)),
            'info' => $this->faker->sentence(3, true),
            'fk_discord_users' => $discord_bot->id,
        ];

        // Creating bot
        $this->actingAs($user)
             ->post(route('bots.store', $input))
             ->assertOk();
        $bot = Bots::where('fk_discord_users', $discord_bot->id)->first();
        // Checking if bot was created
        $this->assertDatabaseHas('bots', $bot->getAttributes());

        // Incorrect values //
        // Creating Bot
        $discord_bot = factory(DiscordUsers::class)->create();
        $input = [
            'name' => $this->faker->userName,
            'prefix' => str_random(random_int(6, 20)),
            'info' => $this->faker->sentence(3, true),
            'fk_discord_users' => $discord_bot->id,
        ];
        $this->actingAs($user)
             ->post(route('bots.store', $input))
             ->assertRedirect(route('bots.create'));
        // Checking if bot wasn't created
        $this->assertDatabaseMissing('bots', [
            'fk_discord_users' => $discord_bot->id,
        ]);

        // Long usename
        $input['name'] = str_random(60);
        $input['prefix'] = str_random(random_int(1, 5));
        $this->actingAs($user)
             ->post(route('bots.store', $input))
             ->assertRedirect(route('bots.create'));
        // Checking if bot wasn't created
        $this->assertDatabaseMissing('bots', [
            'fk_discord_users' => $discord_bot->id,
        ]);

        // Wrong ID
        $input['name'] = $this->faker->userName;
        $input['fk_discord_users'] = $this->faker->randomNumber(9);
        $this->actingAs($user)
             ->post(route('bots.store', $input))
             ->assertRedirect(route('bots.create'));
        // Checking if bot wasn't created
        $this->assertDatabaseMissing('bots', [
            'fk_discord_users' => $discord_bot->id,
        ]);
    }
}
