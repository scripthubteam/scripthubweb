<?php

use Illuminate\Database\Seeder;

use App\DiscordUsers;
use App\ScriptHubUsers;

class DiscordUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(DiscordUsers::class, 51)->create();
    }
}
