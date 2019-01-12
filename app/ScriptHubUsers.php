<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ScriptHubUsers extends Model
{
    // Table to connect
    protected $table = 'scripthub_users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username',
        'email',
        'password',
        'description',
        'discord_users_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * Gets the Discord User.
     *
     * @return  discord_user The Discord User of the ScriptHub User.
     */
    public function discord_user() {
        return $this->belongsTo('App\DiscordUsers', 'discord_users_id', 'id');
    }
}
