<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

use \App\ScriptHubUsers;
use App\DiscordUsers;
use App\Bots;

use \Carbon\Carbon;

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

    /**
     * Test if there are not security issues while adding bots.
     *
     * @return void
     */
    public function testSecurityAtCreatingBots() {
        // Creating User for access
        $user = factory(ScriptHubUsers::class)->create([
            'email_verified_at' => Carbon::now(),
        ]);
        $this->actingAs($user)
             ->get(route('bots.create'))
             ->assertOk();

        // Creating Bot
        $discord_bot = factory(DiscordUsers::class)->create();

        // Setting up Faker
        $this->setUpFaker();

        // Mass assignment //
        // Declaring input
        $input = [
            'name' => $this->faker->userName,
            'prefix' => str_random(random_int(1, 5)),
            'info' => $this->faker->sentence(3, true),
            'fk_discord_users' => $discord_bot->id,
            'validated' => true,
            'popularity' => 123,
        ];
        $this->actingAs($user)
             ->post(route('bots.store', $input))
             ->assertOk();
        $bot = Bots::where('fk_discord_users', $discord_bot->id)->first();
        // Checking if bot was created
        $this->assertDatabaseHas('bots', $bot->getAttributes());
        // Checking for mass assignment
        $this->assertFalse($bot->validated);
        $this->assertTrue($bot->popularity == 0);

        // Falsehood of identity
        $random_user = factory(ScriptHubUsers::class)->create([
            'email_verified_at' => Carbon::now(),
        ]);
        $discord_bot = factory(DiscordUsers::class)->create();
        $input = [
            'name' => $this->faker->userName,
            'prefix' => str_random(random_int(1, 5)),
            'info' => $this->faker->sentence(3, true),
            'fk_discord_users' => $discord_bot->id,
            'fk_scripthub_users' => $random_user->id,
            'fk_scripthub_users_discord_users' => $random_user->fk_discord_users,
        ];
        $this->actingAs($user)
             ->post(route('bots.store', $input))
             ->assertOk();
        $bot = Bots::where('fk_discord_users', $discord_bot->id)->first();
        // Checking if bot was created
        $this->assertDatabaseHas('bots', $bot->getAttributes());
        // Checking for falsehood of identity
        $this->assertFalse($bot->fk_scripthub_users == $random_user->id);
        $this->assertFalse($bot->fk_scripthub_users_discord_users == $random_user->fk_discord_users);
    }
}
