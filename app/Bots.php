<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bots extends Model
{
    // Table to connect
    protected $table = 'bots';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'prefix',
        'info',
        'fk_discord_users',
    ];

    /**
     * Declares which attributes are dates.
     */
    protected $dates = ['requested_at'];

    /**
     * Declares when to use timestamps.
     *
     * @var boolean
     */
    public $timestamps = false;

    /**
     * Gets owner.
     *
     * @return App\ScriptHubUsers scripthub_user
     */
    public function scripthub_user() {
        return $this->belongsTo('App\ScriptHubUsers', 'fk_scripthub_users', 'id');
    }

    /**
     * Gets the Discord Owner.
     *
     * @return App\DiscordUsers discord_user
     */
    public function discord_user() {
        return $this->belongsTo('App\DiscordUsers', 'fk_discord_users', 'id');
    }
}
