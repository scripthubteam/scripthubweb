<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

use \App\TempRegistration;
use \App\Bots;
use \App\ScriptHubUsers;
use \App\DiscordUsers;

use \Carbon\Carbon;

class UserRegistrationTest extends TestCase
{

    use RefreshDatabase;

    /**
     * Do the next:<br>
     * <ul>
     * <li>Enters register</li>
     * <li>Try to register</li>
     * <li>Checks if registration was successful and TempRegistration was removed</li>
     * <li>Logout and verifies email</li>
     * <li>Tries to login</li>
     * </ul>
     *
     * @return void
     */
    public function testRegister()
    {
        $tmp = factory(TempRegistration::class)->create();
        $discord_user = $tmp->discord_user;

        // Access registration and tries to register
        $this->get(route('register'))
             ->assertSee('¡Únete a Script Hub Team!');
        $this->post(route('register'), [
            'username' => 'LeCuay',
            'email' => 'cuayteron@live.com',
            'password' => 'password',
            'repeat_password' => 'password',
            'discord_users_id' => $tmp->discord_user->id,
            'hash_code' => $tmp->hash_code,
        ]);

        // Checks if user was created and temp was removed
        $this->assertDatabaseHas('scripthub_users', [
            'username' => 'LeCuay',
        ]);
        $this->assertDatabaseMissing('tmp_registration', [
            'discord_users_id' => $tmp->discord_user->id,
        ]);

        // Logout
        $this->post('logout');
        $this->assertFalse(\Auth::check());

        // Verify email
        $user = $discord_user->scripthub_user;
        $user->email_verified_at = \Carbon\Carbon::now();
        $user->save();

        // Access login and tries to login
        $this->get(route('login'))
             ->assertSee('¡Bienvenido a Script Hub!');
        $this->post(route('login'), [
            'username' => 'LeCuay',
            'password' => 'password',
        ]);
        $this->assertAuthenticatedAs($user);
    }

    /**
     * Once logged, the user access to his/her bots.
     *
     * @return void
     */
    public function testAccessToBots() {
        // Creates user and its bots.
        $user = factory(ScriptHubUsers::class)->create([
            'email_verified_at' => Carbon::now(),
        ]);
        $bots = factory(Bots::class, 3)->create([
            'scripthub_users_id' => $user->id,
            'scripthub_users_discord_users_id' => $user->discord_user->id,
            ]);

        foreach ($bots as $bot) {
            $this->actingAs($user)
                 ->get(route('bots.index'))
                 ->assertSee($bot->name);
        }
    }

    /**
     * Checks if User is logged and can access to his/her information.<br>
     *
     * @return void
     */
    public function testLogin() {
        $user = factory(ScriptHubUsers::class)->create([
            'username' => 'LeCuay',
            'password' => 'password',
            'email_verified_at' => Carbon::now(),
        ]);

        // Sees name
        $this->actingAs($user)
             ->get('home')
             ->assertSee($user->username);

        // Sees Discord ID
        $this->actingAs($user)
             ->get('home')
             ->assertSee($user->discord_users_id);

        // Sees description
        $description = \Faker\Factory::create()->sentence;
        $user->description = $description;
        $user->save();
        $this->actingAs($user)
             ->get('home')
             ->assertSee($user->description);

        // Access edit
        $random_user = factory(ScriptHubUsers::class)->create([
            'email_verified_at' => Carbon::now()
        ]);
        $this->actingAs($random_user)
             ->get(route('users.edit', $user))
             ->assertForbidden();
        $this->actingAs($user)
             ->get(route('users.edit', $user))
             ->assertOk();
    }
}
