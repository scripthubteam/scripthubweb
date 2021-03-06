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
            $table->string('id', 50)->comment('Discord ID identifier for bot.');
            $table->string('name', 50)->comment('The nickname of the bot.');
            $table->timestamp('requested_at')->useCurrent()->comment('Date when bot was requested.');
            $table->char('prefix', 10)->unique()->comment('Prefix for the bot');
            $table->text('info')->default('Beep boop beep?')->nullable()->comment('Info about the bot');
            $table->text('avatar_url')->nullable()->comment('Value for the URL to the avatar.');
            $table->boolean('validated')->default(false)->comment('Declares if the Bot is part of the Discord Server.');
            $table->integer('popularity')->default(0)->comment('The popularity of the Bot in the Discord Server.');
            $table->unsignedInteger('fk_scripthub_users')->comment('The ID for the Script Hub User owner.');
            $table->string('fk_scripthub_users_discord_users', 50)->comment('The Discord ID for the owner.');

            // Setting primary key
            $table->primary('id');

            // Setting up foreing keys
            $table->foreign('fk_scripthub_users')
                  ->references('id')
                  ->on('scripthub_users')
                  ->onDelete('cascade');
            $table->foreign('fk_scripthub_users_discord_users')
                  ->references('fk_discord_users')
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
