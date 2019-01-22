<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DiscordUsers extends Model
{
    // Table to connect
    protected $table = 'discord_users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'nick',
        'avatar_url',
        'created_at',
    ];

    /**
     * Declares which attributes are dates.
     */
    protected $dates = ['created_at'];

    /**
     * Declares when to use timestamps.
     *
     * @var boolean
     */
    public $timestamps = false;

    /**
     * Gets the Script Hub User.
     *
     * @return  App\ScriptHubUsers scripthub_user
     */
    public function scripthub_user() {
        return $this->hasOne('App\ScriptHubUsers', 'discord_users_id', 'id');
    }

    /**
     * Gets the bots of the User.
     *
     * @return App\Bots bots
     */
    public function bots() {
        return $this->hasMany('App\Bots', 'owner_discord_users_id', 'id');
    }
}
