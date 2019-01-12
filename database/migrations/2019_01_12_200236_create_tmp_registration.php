<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTmpRegistration extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tmp_registration', function (Blueprint $table) {
            $table->increments('id')->comment('Declares the row ID.');
            $table->string('hash_code')->comment('Hash code generate from SHA256 to (discord_id + nick).');
            $table->timestamp('requested_at')->useCurrent()->comment('Declares when the request was made.');
            $table->string('discord_users_id', 50)->comment('The ID the references the Discord User.');

            // Setting up Foreign Key
            $table->foreign('discord_users_id')->references('id')->on('discord_users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tmp_registration');
    }
}