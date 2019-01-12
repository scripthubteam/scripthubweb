<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TempRegistration extends Model
{
    // Table to connect
    protected $table = 'tmp_registration';

    /**
     * Declares when to use timestamps.
     *
     * @var boolean
     */
    public $timestamps = false;
}
