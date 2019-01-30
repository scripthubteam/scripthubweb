<?php

use Illuminate\Database\Seeder;

use App\DiscordUsers;
use App\ScriptHubUsers;
use App\Bots;

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
            'description' => 'Oh lord I dont know what I will do-o-o-o-o. All I do is sit and si-i-i-i-gh OH LORD!',
            'is_admin' => true,
            'fk_discord_users' => $discord_user->id,
            ]);

        $bots = factory(Bots::class, 4)->create([
            'fk_scripthub_users' => $user->id,
            'fk_scripthub_users_discord_users' => $discord_user->id,
        ]);
    }
}
