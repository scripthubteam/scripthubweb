<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

use App\ScriptHubUsers;

use Faker\Factory;
use Carbon\Carbon;

class LoginTest extends DuskTestCase
{

    use DatabaseMigrations;

    /**
     * Checks if user can Log in with browser.
     *
     * @return void
     * @throws \Throwable
     */
    public function testLogin()
    {
        $password = 'password';
        $user = factory(ScriptHubUsers::class)->create([
            'password' => $password,
            'email_verified_at' => Carbon::now(),
        ]);

        $this->browse(function (Browser $browser) use ($user, $password) {
            $browser->visit('/login')
                    ->type('input[name="username"]', $user->username)
                    ->type('input[name="password"]', $password)
                    ->click('input[type="submit"].btn')
                    ->assertPathIs('/home');

            $editLink = '/users/' . $user->id . '/edit';
            $newName = Factory::create()->userName;
            $browser->visit($editLink)
                    ->type('input[name="username"]', $newName)
                    ->screenshot('editProfile')
                    ->press('Actualizar')
                    ->screenshot('newHome');
        });
    }
}
