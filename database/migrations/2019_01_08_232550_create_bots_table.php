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
            $table->increments('id')->comment('Discord ID identifier for bot.');
            $table->string('name', 50)->comment('The nickname of the bot.');
            $table->timestamp('requested_at')->useCurrent()->comment('Date when bot was requested.');
            $table->char('prefix', 5)->unique()->comment('Prefix for the bot');
            $table->text('info')->default('Beep boop beep?')->nullable()->comment('Info abot the bot');
            $table->boolean('validated')->default(false)->comment('Declares if the Bot is on out Discord Server.');
            $table->string('discord_users_id', 50)->unique()->comment('The Discord ID for the bot.');
            $table->unsignedInteger('scripthub_users_id')->comment('The ID for the Script Hub User owner.');
            $table->string('scripthub_users_discord_users_id', 50)->comment('The Discord ID for the owner.');

            // Setting up foreing keys
            $table->foreign('scripthub_users_id')
                  ->references('id')
                  ->on('scripthub_users')
                  ->onDelete('cascade');
            $table->foreign('discord_users_id')
                  ->references('id')
                  ->on('discord_users')
                  ->onDelete('cascade');
            $table->foreign('scripthub_users_discord_users_id')
                  ->references('discord_users_id')
                  ->on('scripthub_users')
                  ->onDelete('cascade');
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
