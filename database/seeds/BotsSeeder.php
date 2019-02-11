<?php

use Illuminate\Database\Seeder;
use App\Bots;

class BotsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Bots::class, 15)->create();
    }
}
