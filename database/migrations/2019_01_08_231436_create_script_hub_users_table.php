<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateScriptHubUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('scripthub_users', function (Blueprint $table) {
            $table->increments('id')->comment('Identifier for row.');
            $table->string('username', 45)->unique()->comment('The username used for login.');
            $table->string('email', 100)->unique()->comment('The email used for register.');
            $table->timestamp('email_verified_at')->nullable()->comment('Security to verify that email exists');
            $table->boolean('is_admin')->default(false)->comment('Declares if user is admin.');
            $table->string('password')->comment('The password used for login');
            $table->text('description')->nullable()->comment('Description of the user.');
            $table->text('avatar_url')->nullable()->comment('The Avatar URL if needed.');
            $table->timestamps();
            $table->rememberToken()->comment('Token used for password recover.');
            $table->string('discord_users_id', 50)->unique()->comment('The Discord User associated with this Script Hub User.');

            // Setting up Foreing Key
            $table->foreign('discord_users_id')
                  ->references('id')
                  ->on('discord_users')
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
        Schema::dropIfExists('scripthub_users');
    }
}
