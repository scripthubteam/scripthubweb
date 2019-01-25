<?php

use Illuminate\Database\Seeder;

use App\DiscordUsers;
use App\ScriptHubUsers;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $discord_user = DiscordUsers::create([
            'id' => '316302647722377219',
            'nick' => 'Chechu-さん',
            'avatar_url' => '',
            'created_at' => Carbon\Carbon::now(),
            ]);

        $user = factory(ScriptHubUsers::class)->create([
            'username' => 'LeCuay',
            'password' => 'password',
            'email_verified_at' => Carbon\Carbon::now(),
            'is_admin' => true,
            'discord_users_id' => $discord_user->id,
            ]);
    }
}
