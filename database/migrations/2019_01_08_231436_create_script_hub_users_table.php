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
            $table->string('email', 45)->unique()->comment('The email used for register.');
            $table->boolean('is_admin')->default(false)->comment('Declares if user is admin.');
            $table->string('password')->comment('The password used for login');
            $table->text('description')->nullable()->comment('Description of the user.');
            $table->timestamps();
            $table->rememberToken()->comment('Token used for password recover.');
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
