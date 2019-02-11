<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        $this->call(ScriptHubUsersSeeder::class);
        $this->call(DiscordUsersSeeder::class);
        $this->call(AdminSeeder::class);
        $this->call(BotsSeeder::class);
    }
}
