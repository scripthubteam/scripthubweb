<?php

use Illuminate\Database\Seeder;

use App\DiscordUsers;
use App\ScriptHubUsers;

class ScriptHubUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(ScriptHubUsers::class, 32)->create();
    }
}
