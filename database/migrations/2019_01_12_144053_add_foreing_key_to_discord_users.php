<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeingKeyToDiscordUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('discord_users', function (Blueprint $table) {
            // Setting up foreign key
            $table->foreign('scripthub_users_id')->references('id')->on('scripthub_users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('discord_users', function (Blueprint $table) {
            // Drop
            $table->dropForeign('scripthub_users_id');
        });
    }
}
