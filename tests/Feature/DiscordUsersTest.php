<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

use \App\DiscordUsers;
use \App\ScriptHubUsers;

use \Carbon\Carbon;

class DiscordUsersTest extends TestCase
{

    use RefreshDatabase;

    /**
     * Checks if an Admin can see a list of all discord users.
     *
     * @return void
     */
    public function testListDiscordUsers()
    {
        // Creates 40 random users
        factory(DiscordUsers::class, 40)->create();

        // Creates Admin
        $user = factory(ScriptHubUsers::class)->create([
            'email_verified_at' => Carbon::now(),
            'is_admin' => true,
        ]);

        // Access
        $this->actingAs(factory(ScriptHubUsers::class)->create(['email_verified_at' => Carbon::now()]))
             ->get(route('discord.index'))
             ->assertForbidden();

        $this->actingAs($user)
             ->get(route('discord.index'))
             ->assertOk();

        // See first 15 users
        foreach (DiscordUsers::orderBy('created_at', 'asc')->paginate(15) as $discord_user) {
            $this->actingAs($user)
                 ->get(route('discord.index'))
                 ->assertSee($discord_user->nick);
        }
    }
}
