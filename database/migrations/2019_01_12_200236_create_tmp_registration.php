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
        // insert into tmp_registration(hash_code, fk_discord_users) values('1234', '316302647722377219');
        Schema::create('tmp_registration', function (Blueprint $table) {
            $table->increments('id')->comment('Declares the row ID.');
            $table->string('hash_code')->comment('Hash code generate from SHA256 to (discord_id + nick).');
            $table->timestamp('requested_at')->useCurrent()->comment('Declares when the request was made.');
            $table->string('fk_discord_users', 50)->unique()->comment('The ID the references the Discord User.');

            // Setting up Foreign Key
            $table->foreign('fk_discord_users')
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
        Schema::dropIfExists('tmp_registration');
    }
}
