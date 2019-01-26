<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

use \App\TempRegistration;
use \App\Bots;
use \App\ScriptHubUsers;
use \App\DiscordUsers;

use \Carbon\Carbon;
use \Faker\Factory;

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
        // Temporary registration
        $tmp = factory(TempRegistration::class)->create();
        $discord_user = $tmp->discord_user;

        // Random input
        $faker = Factory::create();
        $password = $faker->password;
        $input = [
            'username' => $faker->username,
            'email' => $faker->email,
            'password' => $password,
            'repeat_password' => $password,
            'discord_users_id' => $tmp->discord_user->id,
            'hash_code' => $tmp->hash_code,
        ];

        // Access registration and tries to register
        $this->get(route('register'))
             ->assertSee('¡Únete a Script Hub Team!');
        $this->post(route('register'), $input);

        // Checks if user was created and temp was removed
        $this->assertDatabaseHas('scripthub_users', [
            'username' => $input['username'],
        ]);
        $this->assertDatabaseMissing('tmp_registration', [
            'discord_users_id' => $tmp->discord_user->id,
        ]);

        // Logout
        $this->post('logout');
        $this->assertFalse(\Auth::check(), 'The user still authenticated.');

        // Verify email
        $user = $discord_user->scripthub_user;
        $user->email_verified_at = Carbon::now();
        $user->save();

        // Access login and tries to login
        $welcome_message = '¡Bienvenido a Script Hub!';
        $this->get(route('login'))
             ->assertSee($welcome_message);
        $this->post(route('login'), [
            'username' => $input['username'],
            'password' => $input['password'],
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

        // Checks if user can see every bot
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
        // Creates random user
        $user = factory(ScriptHubUsers::class)->create([
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
        $description = Factory::create()->sentence;
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

        // View is correct
        $this->actingAs($user)
             ->get(route('users.edit', $user))
             ->assertViewIs('users.edit');
    }

    /**
     * Checks if a user can edit itself.
     *
     * @return void
     */
    public function testEditUser() {
        // Creating users
        $user = factory(ScriptHubUsers::class)->create([
            'email_verified_at' => Carbon::now(),
        ]);
        $random_user = factory(ScriptHubUsers::class)->create([
            'email_verified_at' => Carbon::now()
        ]);

        // Redirecting because empty
        $this->actingAs($random_user)
             ->put(route('users.update', $user), [])
             ->assertStatus(302);
        $this->actingAs($user)
             ->put(route('users.update', $user), [])
             ->assertStatus(302);

        // Random input
        $faker = Factory::create();
        $input = [
            'username' => $faker->username,
            'email' => $faker->safeEmail,
            'password' => $faker->password,
            'description' => $faker->paragraph,
        ];

        // Editing (with forbidden)
        $this->actingAs($random_user)
             ->put(route('users.update', $user), $input)
             ->assertForbidden();
        $this->actingAs($user)
             ->put(route('users.update', $user), $input)
             ->assertRedirect(route('home'));

        // Checking if everything has changed.
        $this->assertTrue($user->username == $input['username'],
                          'The username wasn\'t updated -> ' . $user->username . ' != \'' . $input['username'] .'\'');
        $this->assertTrue($user->email == $input['email'],
                          'The email wasn\'t updated -> ' . $user->email . ' != \'' . $input['email'] .'\'');
        $this->assertTrue(\Hash::check($input['password'], $user->password), 'The password wasn\'t updated');
        $this->assertTrue($user->description == $input['description'],
                          'The description wasn\'t updated -> ' . $user->description . ' != \'' . $input['description'] .'\'');

        // Editing (without password or description)
        $password = $input['password'];
        $description = $input['description'];
        $input = [
            'username' => $faker->username,
            'email' => $faker->safeEmail,
        ];
        $this->actingAs($user)
             ->put(route('users.update', $user), $input)
             ->assertRedirect(route('home'));

        // Checking if everything has changed but password.
        $this->assertTrue($user->username == $input['username'],
                          'The username wasn\'t updated -> ' . $user->username . ' != \'' . $input['username'] .'\'');
        $this->assertTrue($user->email == $input['email'],
                          'The email wasn\'t updated -> ' . $user->email . ' != \'' . $input['email'] .'\'');
        $this->assertTrue(\Hash::check($password, $user->password), 'The password wasn\'t updated');
        $this->assertTrue($user->description == $description,
                          'The description wasn\'t updated -> ' . $user->description . ' != \'' . $description .'\'');
    }
}
