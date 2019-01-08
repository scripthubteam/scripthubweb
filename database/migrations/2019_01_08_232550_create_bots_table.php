<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBotsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bots', function (Blueprint $table) {
            $table->string('id')->comment('Discord ID identifier for bot.');
            $table->timestamp('requested')->useCurrent()->comment('Date when bot was requested.');
            $table->char('prefix', 5)->comment('Prefix for the bot');
            $table->text('info')->default('Beep boop beep?')->nullable()->comment('Info abot the bot');
            $table->integer('owner_scripthub_user_id')->comment('The ID for the Script Hub User owner.');
            $table->string('owner_discord_user_id', 50)->comment('The Discord ID for the owner.');

            // Setting up foreing keys
            $table->foreign('owner_scripthub_user_id')->references('id')->on('scripthub_users');
            $table->foreign('owner_discord_user_id')->references('id')->on('discord_users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bots');
    }
}
