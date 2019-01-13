<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TempRegistration extends Model
{
    // Table to connect
    protected $table = 'tmp_registration';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'hash_code',
        'discord_users_id',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'hash_code',
    ];

    /**
     * Declares when to use timestamps.
     *
     * @var boolean
     */
    public $timestamps = false;

    /**
     * Deletes a Temporary Registration by discord id.
     *
     * @var string $discord_users_id
     */
    public static function deleteById(string $discord_users_id) {
        static::where('discord_users_id', $discord_users_id)->first()->delete();
    }

    /**
     * Returns the Discord User associated to this Temporary Registration.
     *
     * @return App\DiscordUsers discord_user
     */
    public function discord_user() {
        return $this->belongsTo('App\DiscordUsers', 'discord_users_id', 'id');
    }
}
