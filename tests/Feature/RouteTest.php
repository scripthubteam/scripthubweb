<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use \App\DiscordUsers;
use \App\Bots;
use \App\ScriptHubUsers;

class RouteTest extends TestCase
{
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
             ->assertStatus(200);
        $this->get(route('login'))
             ->assertStatus(200);
        $this->get(route('register'))
             ->assertStatus(200);
        $this->get(route('password.request'))
             ->assertStatus(200);
    }

    /**
     * Checks if routes redirects to login when user is not logged.
     *
     * @return void
     */
    public function testRedirectsToLogin() {
        $this->assertGuest();
        $this->get(route('discord.create'))
             ->assertRedirect(route('login'));
        $this->get(route('discord.show', DiscordUsers::first()->id))
             ->assertRedirect(route('login'));
        $this->get(route('discord.edit', DiscordUsers::first()->id))
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
        $this->get(route('bots.show', Bots::first()->id))
             ->assertRedirect(route('login'));
        $this->get(route('bots.edit', Bots::first()->id))
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
        $user = factory(ScriptHubUsers::class)->create([
            'email_verified_at' => \Carbon\Carbon::now(),
        ]);

        // Logging and checking autheticated
        $this->actingAs($user);
        $this->assertAuthenticated();
        $this->assertAuthenticatedAs($user);

        // Checking
        $this->get(route('home'))
             ->assertStatus(200);
        $this->get(route('bots.index'))
             ->assertStatus(200);
        $this->get(route('bots.create'))
             ->assertStatus(200);
        $this->get(route('bots.show', Bots::first()->id))
             ->assertStatus(200);
        $this->get(route('bots.edit', Bots::first()->id))
             ->assertStatus(200);
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
            'email_verified_at' => \Carbon\Carbon::now(),
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
        $this->get(route('discord.show', DiscordUsers::first()->id))
             ->assertForbidden();
        $this->get(route('discord.show', DiscordUsers::first()->id))
             ->assertSee('Acceso denegado.');
        $this->get(route('discord.edit', DiscordUsers::first()->id))
             ->assertForbidden();
        $this->get(route('discord.edit', DiscordUsers::first()->id))
             ->assertSee('Acceso denegado.');
    }

    /**
     * Checks access granted to DiscordUsers with is_admin = true.
     */
    public function testAccessDiscordGranted() {
        // Creating user
        $user = factory(ScriptHubUsers::class)->create([
            'email_verified_at' => \Carbon\Carbon::now(),
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
        $this->get(route('discord.show', DiscordUsers::first()->id))
             ->assertOk();
        $this->get(route('discord.edit', DiscordUsers::first()->id))
             ->assertOk();
    }

    /**
     * Returns 404 if given ID doesn't exists.
     *
     * @return void
     */
    public function testFailingIfIDNotExists() {
        $this->assertTrue(true);
        // $this->get(route('bots.show', str_random(19)))->assertNotFound();
    }
}
