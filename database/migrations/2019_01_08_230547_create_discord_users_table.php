<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDiscordUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('discord_users', function (Blueprint $table) {
            $table->string('id', 50)->comment('Discord ID used as primary key.');
            $table->string('nick', 45)->comment('Discord Username');
            $table->text('avatar_url')->nullable()->comment('URL to Avatar if needed.');
            $table->timestamp('created_at')->comment('Declares when this Discord User was created.');

            // Setting up primary key
            $table->primary('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('discord_users');
    }
}
