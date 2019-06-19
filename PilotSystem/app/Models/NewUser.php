<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Laratrust\Traits\LaratrustUserTrait;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Auth\Authenticatable;

/**
 * App\Models\NewUser
 *
 * @property int $uid
 * @property string $email
 * @property string $username
 * @property string $password
 * @property int $status
 * @property int $emailstatus
 * @property int $avatarstatus
 * @property int $videophotostatus
 * @property int $adminid
 * @property int $groupid
 * @property int $groupexpiry
 * @property string $extgroupids
 * @property int $regdate
 * @property int $credits
 * @property int $notifysound
 * @property string $timeoffset
 * @property int $newpm
 * @property int $newprompt
 * @property int $accessmasks
 * @property int $allowadmincp
 * @property int $onlyacceptfriendpm
 * @property int $conisbind
 * @property int $freeze
 * @property-read \App\Models\NewUserDetail $detail
 * @property-read mixed $a_t_c_delta_time
 * @property-read mixed $a_t_c_time
 * @property-read mixed $banned
 * @property-read mixed $callsign
 * @property-read mixed $delta_time
 * @property-read mixed $flight_permission
 * @property-read mixed $is_a_t_c
 * @property-read mixed $manage_a_t_c
 * @property-read mixed $online_time
 * @property-read mixed $platform
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\NewUser newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\NewUser newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\NewUser query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\NewUser whereAccessmasks($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\NewUser whereAdminid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\NewUser whereAllowadmincp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\NewUser whereAvatarstatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\NewUser whereConisbind($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\NewUser whereCredits($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\NewUser whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\NewUser whereEmailstatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\NewUser whereExtgroupids($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\NewUser whereFreeze($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\NewUser whereGroupexpiry($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\NewUser whereGroupid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\NewUser whereNewpm($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\NewUser whereNewprompt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\NewUser whereNotifysound($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\NewUser whereOnlyacceptfriendpm($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\NewUser wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\NewUser whereRegdate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\NewUser whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\NewUser whereTimeoffset($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\NewUser whereUid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\NewUser whereUsername($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\NewUser whereVideophotostatus($value)
 * @mixin \Eloquent
 */
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

    public function getManageATCAttribute()
    {
        return $this->detail->field1 == 1 && $this->detail->field3 > 2;
    }

    public function detail()
    {
        return $this->hasOne('App\Models\NewUserDetail','uid', 'uid');
    }
}
