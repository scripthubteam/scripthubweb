<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
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
        $this->get('/')->assertStatus(200);
        $this->get('login')->assertStatus(200);
        $this->get('register')->assertStatus(200);
        $this->get('password/reset')->assertStatus(200);
    }

    /**
     * Checks if routes redirects to login when user is not logged.
     *
     * @return void
     */
    public function testRedirectsToLogin() {
        $this->assertGuest();
        $this->get('email/resend')->assertRedirect('login');
        $this->get('email/verify')->assertRedirect('login');
        $this->get('email/verify/' . random_int(0, 100))->assertRedirect('login');
        $this->get('home')->assertRedirect('login');
        $this->get('user/bots')->assertRedirect('login');
        $this->get('user/bots/create')->assertRedirect('login');
        $this->get('user/bots/' . random_int(0, 100))->assertRedirect('login');
        $this->get('user/bots/' . random_int(0, 100) . 'edit')->assertRedirect('login');
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
        $this->get('home')
             ->assertStatus(200);
        $this->get('user/bots')
             ->assertStatus(200);
        $this->get('user/bots/create')
             ->assertStatus(200);
    }
}
