<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

use Illuminate\Support\Carbon;

use \App\TempRegistration;
use \App\Bots;
use \App\ScriptHubUsers;
use \App\DiscordUsers;

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
            'username' => $faker->userName,
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
        $this->assertDatabaseMissing('tmp_registration', $tmp->getAttributes());

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

        // Redirecting because forbidden
        $this->actingAs($random_user)
             ->put(route('users.update', $user), [])
             ->assertForbidden();

        // Redirecting because empty
        $this->actingAs($user)
             ->put(route('users.update', $user), [])
             ->assertStatus(302);

        // Random input
        $faker = Factory::create();
        $password = $faker->password;
        $input = [
            'username' => $faker->userName,
            'email' => $faker->safeEmail,
            'password' => $password,
            'repeat_password' => $password,
            'description' => $faker->paragraph,
        ];

        // Editing (with forbidden)
        $this->actingAs($random_user)
             ->put(route('users.update', $user), $input)
             ->assertForbidden();
        $before = $user->username;
        $this->actingAs($user)
             ->put(route('users.update', $user), $input)
             ->assertRedirect(route('home'));

        // Refreshing model
        $user->refresh();

        // Checking if everything has changed.
        $this->assertTrue($user->username == $input['username'],
                          'The username wasn\'t updated -> ' . $user->username . ' != '  . $input['username']);
        $this->assertTrue($user->email == $input['email'],
                          'The email wasn\'t updated -> ' . $user->email . ' != ' . $input['email']);
        $this->assertTrue(\Hash::check($input['password'], $user->password), 'The password wasn\'t updated');
        $this->assertTrue($user->description == $input['description'],
                          'The description wasn\'t updated -> ' . $user->description . ' != ' . $input['description']);

        // Editting (with same username)
        $input = [
            'username' => $user->username,
        ];
        $this->actingAs($user)
             ->put(route('users.update', $user), $input)
             ->assertRedirect(route('users.edit', $user));

        // Editting (with same username and email)
        $input = [
            'username' => $user->username,
            'email' => $user->email,
        ];
        $this->actingAs($user)
             ->put(route('users.update', $user), $input)
             ->assertRedirect(route('users.edit', $user));

        // Editting (changing password)
        $password = $faker->password();
        $input = [
            'username' => $user->username,
            'email' => $user->email,
            'password' => $password,
            'repeat_password' => $password,
        ];
        $this->actingAs($user)
             ->put(route('users.update', $user), $input)
             ->assertRedirect(route('home'));

        // Refreshing model
        $user->refresh();

        // Checking password has changed
        $this->assertTrue(\Hash::check($input['password'], $user->password), 'The password wasn\'t updated');

        // Editting (changing description)
        $input = [
            'username' => $user->username,
            'email' => $user->email,
            'description' => $faker->paragraph,
        ];
        $this->actingAs($user)
             ->put(route('users.update', $user), $input)
             ->assertRedirect(route('home'));

        // Refreshing model
        $user->refresh();

        // Checking if description has changed
        $this->assertTrue($user->description == $input['description'],
                          'The description wasn\'t updated -> ' . $user->description . ' != ' . $input['description']);
    }

    /**
     * Checks if user can upload avatar<br>
     * Checks if uploaded file is image.
     *
     * @return void
     */
    public function testUploadAvatar() {
        Storage::fake('public');

        // Creating user
        $user = factory(ScriptHubUsers::class)->create([
            'email_verified_at' => Carbon::now(),
        ]);

        // Editting avatar
        $file = UploadedFile::fake()->image('avatar.jpg');
        $input = [
            'avatar' => $file,
        ];
        $this->actingAs($user)
             ->put(route('users.update', $user), $input)
             ->assertRedirect(route('home'));

        // Assert the file was stored
        $storage_path = 'avatars/' . $user->id . '_avatar.' . $file->extension();
        Storage::disk('public')->assertExists($storage_path);

        // Refresh user
        $user->refresh();

        // Giving not-image file
        $file = UploadedFile::fake()->create('archive.txt');
        $input = [
            'avatar' => $file,
        ];
        $this->actingAs($user)
             ->put(route('users.update', $user), $input)
             ->assertStatus(302);
    }

    /**
     * Checks if a user can remove itself.
     *
     * @return void
     */
    public function testRemoveUser() {
        // Creating random users
        $user = factory(ScriptHubUsers::class)->create([
            'email_verified_at' => Carbon::now(),
        ]);
        $random_user = factory(ScriptHubUsers::class)->create([
            'email_verified_at' => Carbon::now(),
        ]);

        // Editting (with forbidden)
        $this->actingAs($random_user)
             ->delete(route('users.destroy', $user))
             ->assertForbidden();
        $this->actingAs($user)
             ->delete(route('users.destroy', $user))
             ->assertRedirect(route('root'));

        // Assert user was destroyed
        $this->assertDatabaseMissing('scripthub_users', $user->getAttributes());
    }
}
