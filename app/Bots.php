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
        'id',
        'requested_at',
        'prefix',
        'info',
        'validated',
        'owner_scripthub_users_id',
        'owner_discord_users_id',
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
        return $this->belongsTo('App\ScriptHubUsers', 'owner_scripthub_users_id', 'id');
    }

    /**
     * Gets the Discord Owner.
     *
     * @return App\DiscordUsers discord_user
     */
    public function discord_user() {
        return $this->belongsTo('App\DiscordUsers', 'owner_discord_users_id', 'id');
    }
}
