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

        // Redirect because empty
        $this->actingAs($user)
             ->post(route('bots.store'))
             ->assertStatus(302);

        // Declaring input
        $input = [
            'id' => $this->faker->randomNumber(9),
            'name' => $this->faker->userName,
            'prefix' => str_random(random_int(1, 5)),
            'info' => $this->faker->sentence(3, true),
        ];

        // Creating bot
        $this->actingAs($user)
             ->post(route('bots.store', $input))
             ->assertOk();
        $bot = Bots::where('id', $input['id'])->first();
        // Checking if bot was created
        $this->assertDatabaseHas('bots', $bot->getAttributes());

        // Incorrect values //
        $input = [
            'id' => $this->faker->randomNumber(9),
            'name' => $this->faker->userName,
            'prefix' => str_random(random_int(11, 20)),
            'info' => $this->faker->sentence(3, true),
        ];
        $this->actingAs($user)
             ->post(route('bots.store', $input))
             ->assertRedirect(route('bots.create'));
        // Checking if bot wasn't created
        $this->assertDatabaseMissing('bots', [
            'id' => $input['id'],
        ]);

        // Long usename
        $input['name'] = str_random(60);
        $input['prefix'] = str_random(random_int(1, 5));
        $this->actingAs($user)
             ->post(route('bots.store', $input))
             ->assertRedirect(route('bots.create'));
        // Checking if bot wasn't created
        $this->assertDatabaseMissing('bots', [
            'id' => $input['id'],
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

        // Mass assignment //
        // Declaring input
        $input = [
            'id' => $this->faker->randomNumber(9),
            'name' => $this->faker->userName,
            'prefix' => str_random(random_int(1, 5)),
            'info' => $this->faker->sentence(3, true),
            'validated' => true,
            'popularity' => 123,
        ];
        $this->actingAs($user)
             ->post(route('bots.store', $input))
             ->assertOk();
        $bot = Bots::where('id', $input['id'])->first();
        // Checking if bot was created
        $this->assertDatabaseHas('bots', $bot->getAttributes());
        // Checking for mass assignment
        $this->assertFalse($bot->validated);
        $this->assertTrue($bot->popularity == 0);

        // Falsehood of identity
        $random_user = factory(ScriptHubUsers::class)->create([
            'email_verified_at' => Carbon::now(),
        ]);
        $input = [
            'id' => $this->faker->randomNumber(9),
            'name' => $this->faker->userName,
            'prefix' => str_random(random_int(1, 5)),
            'info' => $this->faker->sentence(3, true),
            'fk_scripthub_users' => $random_user->id,
            'fk_scripthub_users_discord_users' => $random_user->fk_discord_users,
        ];
        $this->actingAs($user)
             ->post(route('bots.store', $input))
             ->assertOk();
        $bot = Bots::where('id', $input['id'])->first();
        // Checking if bot was created
        $this->assertDatabaseHas('bots', $bot->getAttributes());
        // Checking for falsehood of identity
        $this->assertFalse($bot->fk_scripthub_users == $random_user->id);
        $this->assertFalse($bot->fk_scripthub_users_discord_users == $random_user->fk_discord_users);
    }

    /**
     * Tests if user can edit a bot.
     * Also tests security issues such as editting someone else bot.
     *
     * @return void
     */
    public function testEditBot()
    {
        // User for access
        $user = factory(ScriptHubUsers::class)->create([
            'email_verified_at' => Carbon::now(),
        ]);
        // Other user
        $random_user = factory(ScriptHubUsers::class)->create([
            'email_verified_at' => Carbon::now(),
        ]);
        // Bot
        $bot = factory(Bots::class)->create([
            'id' => $this->faker->randomNumber(9),
            'fk_scripthub_users' => $user->id,
            'fk_scripthub_users_discord_users' => $user->fk_discord_users,
        ]);

        // Creating input
        $input = [
            'name' => $this->faker()->userName,
            'prefix' => str_random(random_int(1, 10)),
        ];

        // Accessing with non-owner user
        $this->actingAs($random_user)
             ->get(route('bots.edit', $bot))
             ->assertRedirect(route('users.bots', $random_user));
        $this->actingAs($random_user)
             ->put(route('bots.update', $bot), $input)
             ->assertForbidden();

        // Accessing with owner
        $this->actingAs($user)
             ->get(route('bots.edit', $bot))
             ->assertOk();
        $this->actingAs($user)
             ->put(route('bots.update', $bot), $input)
             ->assertRedirect(route('bots.show', $bot));

        // Reloading data
        $bot->refresh();
        $this->assertEquals($input['name'], $bot->name, 'Name wasn\'t changed!');
        $this->assertEquals($input['prefix'], trim($bot->prefix), 'Prefix hasn\'t changed!');
    }
}
