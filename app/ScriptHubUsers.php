<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class ScriptHubUsers extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;

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
        'avatar_url',
        'discord_users_id',
    ];

    /**
     * Declares which attributes are dates.
     */
    protected $dates = ['created_at', 'updated_at'];

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

    /**
     * Gets the bots of the User.
     *
     * @return App\Bots bots
     */
    public function bots() {
        return $this->hasMany('App\Bots', 'scripthub_users_id', 'id');
    }

    /**
     * Mutates the password before saving it.
     */
    public function setPasswordAttribute($password) {
        $this->attributes['password'] = Hash::make($password);
    }
}
