<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laratrust\Traits\LaratrustUserTrait;


class ApiUser extends Authenticatable
{
    use LaratrustUserTrait;
    use Notifiable;

    protected $table = "api_users";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'description', 'ip', "api_token"
    ];
}
