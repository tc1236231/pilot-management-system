<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Laratrust\Traits\LaratrustUserTrait;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Auth\Authenticatable;

class NewUser extends Model implements
    AuthenticatableContract
{
    //use LaratrustUserTrait;
    use Authenticatable;
    use Notifiable;
    public $connection = 'platform_bbs';
    public $table = 'bbs_common_member';
    public $primaryKey = 'uid';
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'uid', 'email', 'username', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
    ];

    public function getPlatformAttribute()
    {
        return "COC";
    }

    public function getCallsignAttribute()
    {
        return "{$this->username}";
    }

    public function getFlightPermissionAttribute()
    {
        return $this->detail->field1 == 1;
    }

    public function getBannedAttribute()
    {
        return $this->detail->field1 == 2;
    }

    public function getIsATCAttribute()
    {
        return $this->detail->field3 > 1;
    }

    public function getOnlineTimeAttribute()
    {
        return $this->detail->field2;
    }

    public function getATCTimeAttribute()
    {
        return $this->detail->field4;
    }

    public function getDeltaTimeAttribute()
    {
        return $this->detail->deltatime;
    }

    public function getATCDeltaTimeAttribute()
    {
        return $this->detail->atcdeltatime;
    }

    public function detail()
    {
        return $this->hasOne('App\Models\NewUserDetail','uid', 'uid');
    }
}
