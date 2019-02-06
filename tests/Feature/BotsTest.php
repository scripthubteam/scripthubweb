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
     * Checks if Bot can be updated.
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
        $this->assertDatabaseHas('bots', $bot->getAttributes());

        // Incorrect values
    }
}
