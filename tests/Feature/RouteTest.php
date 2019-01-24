<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

use \App\DiscordUsers;
use \App\Bots;
use \App\ScriptHubUsers;

use \Carbon\Carbon;

class RouteTest extends TestCase
{

    use RefreshDatabase;

    /**
     * Checks if every static (not logged) route is working.<br>
     * All routes must return 200.
     *
     * @return void
     */
    public function testGetsEveryStaticRouteIsWorking()
    {
        $this->assertGuest();
        $this->get(route('root'))
             ->assertOk();
        $this->get(route('login'))
             ->assertOk();
        $this->get(route('register'))
             ->assertOk();
        $this->get(route('password.request'))
             ->assertOk();
        // Creates random Bot
        $bot = factory(Bots::class)->create();
        $this->get(route('bots.show', $bot))
             ->assertOk();
        $this->get(route('bots.show', $bot->id))
             ->assertOk();
    }

    /**
     * Checks if routes redirects to login when user is not logged.
     *
     * @return void
     */
    public function testRedirectsToLogin() {
        // Creates dummies
        factory(Bots::class, 5)->create();

        $this->assertGuest();
        $this->get(route('discord.create'))
             ->assertRedirect(route('login'));
        $this->get(route('discord.show', DiscordUsers::first()))
             ->assertRedirect(route('login'));
        $this->get(route('discord.edit', DiscordUsers::first()))
             ->assertRedirect(route('login'));
        $this->get(route('verification.resend'))
             ->assertRedirect(route('login'));
        $this->get(route('verification.notice'))
             ->assertRedirect(route('login'));
        $this->get(route('home'))
             ->assertRedirect(route('login'));
        $this->get(route('bots.index'))
             ->assertRedirect(route('login'));
        $this->get(route('bots.create'))
             ->assertRedirect(route('login'));
        $this->get(route('bots.edit', Bots::first()))
             ->assertRedirect(route('login'));
    }

    /**
     * Checks if logged-needed routes works.<br>
     * All routes must return status 200.
     *
     * @return void
     */
    public function testGetsLoggedRouteIsWorking()
    {
        // Creating user
        $bot = factory(Bots::class)->create();
        $user = $bot->scripthub_user;
        $user->email_verified_at = Carbon::now();
        $user->save();

        // Logging and checking autheticated
        $this->actingAs($user);
        $this->assertAuthenticated();
        $this->assertAuthenticatedAs($user);

        // Checking
        $this->get(route('home'))
             ->assertOk();
        $this->get(route('bots.index'))
             ->assertOk();
        $this->get(route('bots.create'))
             ->assertOk();
        $this->get(route('bots.show', Bots::first()))
             ->assertOk();
        $this->get(route('bots.edit', Bots::first()))
             ->assertOk();
    }

    /**
     * Checks for forbiden routes.<br>
     * Must reutrn HTTP Error 403.
     *
     * @return void
     */
    public function testAccessDiscordForbidden() {
        // Creating user
        $user = factory(ScriptHubUsers::class)->create([
            'email_verified_at' => Carbon::now(),
        ]);

        // Logging and checking autheticated
        $this->actingAs($user);
        $this->assertAuthenticated();
        $this->assertAuthenticatedAs($user);

        // Checking
        $this->get('discord')
             ->assertForbidden();
        $this->get('discord')
             ->assertSee('Acceso denegado.');
        $this->get(route('discord.create'))
             ->assertForbidden();
        $this->get(route('discord.create'))
             ->assertSee('Acceso denegado.');
        $this->get(route('discord.show', DiscordUsers::first()))
             ->assertForbidden();
        $this->get(route('discord.show', DiscordUsers::first()))
             ->assertSee('Acceso denegado.');
        $this->get(route('discord.edit', DiscordUsers::first()))
             ->assertForbidden();
        $this->get(route('discord.edit', DiscordUsers::first()))
             ->assertSee('Acceso denegado.');
    }

    /**
     * Checks access granted to DiscordUsers with is_admin = true.
     */
    public function testAccessDiscordGranted() {
        // Creating user
        $user = factory(ScriptHubUsers::class)->create([
            'email_verified_at' => Carbon::now(),
            'is_admin' => true,
        ]);

        // Logging and checking autheticated
        $this->actingAs($user);
        $this->assertAuthenticated();
        $this->assertAuthenticatedAs($user);

        // Checking
        $this->get(route('discord.index'))
             ->assertOk();
        $this->get(route('discord.create'))
             ->assertOk();
        $this->get(route('discord.show', DiscordUsers::first()))
             ->assertOk();
        $this->get(route('discord.edit', DiscordUsers::first()))
             ->assertOk();
    }

    /**
     * Returns 404 if given ID doesn't exists.
     *
     * @return void
     */
    public function testFailingIfIDNotExists() {
        // Creating users with permissions
        $user = factory(ScriptHubUsers::class)->create([
            'email_verified_at' => Carbon::now(),
            'is_admin' => true,
        ]);

        // Asserts 404 because 'method not allowed' (we need numbers).
        $this->actingAs($user)
             ->get(route('bots.show', str_random(19)))
             ->assertNotFound();
        $this->actingAs($user)
             ->get(route('bots.edit', str_random(19)))
             ->assertNotFound();

        $this->actingAs($user)
             ->get(route('bots.show', random_int(1000, 5000)))
             ->assertNotFound();
        $this->actingAs($user)
             ->get(route('bots.show', random_int(1000, 5000)))
             ->assertNotFound();

        $this->actingAs($user)
             ->get(route('discord.show', str_random(19)))
             ->assertNotFound();
        $this->actingAs($user)
             ->get(route('discord.edit', str_random(19)))
             ->assertNotFound();
    }
}
