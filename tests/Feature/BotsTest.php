<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

use \App\ScriptHubUsers;

use \Carbon\Carbon;

class BotsTest extends TestCase
{
    /**
     * Checks if Bot can be updated.
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
    }
}
