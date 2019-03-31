<?php

namespace App\Models;

use App\Notifications\CustomVerifyEmail;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laratrust\Traits\LaratrustUserTrait;

/**
 * App\Models\Pilot
 *
 * @property int $id
 * @property string $co
 * @property string $callsign
 * @property string $password
 * @property int $level
 * @property int $via 连飞资格认证
 * @property string|null $icq
 * @property string $email
 * @property string $namelog
 * @property int $onlinetime 飞行时长（秒）
 * @property int $atctime 管制时长（秒）
 * @property int $xiaohaotime
 * @property string $registertime 注册时间
 * @property string $logintime 系统登陆时间
 * @property string $pologintime 飞行员连线时间
 * @property string $poendtime 飞行员断线时间
 * @property string $atclogintime 管制连线时间
 * @property string $atcendtime 管制断线时间
 * @property string|null $realname
 * @property string|null $phone
 * @property string|null $dizhi
 * @property int $deltatime 飞行员增量时间（秒）
 * @property int $atcdeltatime ATC增量时间（秒）
 * @property string|null $txt
 * @property string $uptime
 * @property string|null $token
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Permission[] $permissions
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\PilotPlatform[] $platforms
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Role[] $roles
 * @property-read \App\Models\PilotTimeStats $timeStats
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Pilot newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Pilot newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Pilot orWherePermissionIs($permission = '')
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Pilot orWhereRoleIs($role = '', $team = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Pilot query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Pilot whereAtcdeltatime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Pilot whereAtcendtime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Pilot whereAtclogintime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Pilot whereAtctime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Pilot whereCallsign($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Pilot whereCo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Pilot whereDeltatime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Pilot whereDizhi($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Pilot whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Pilot whereIcq($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Pilot whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Pilot whereLevel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Pilot whereLogintime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Pilot whereNamelog($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Pilot whereOnlinetime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Pilot wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Pilot wherePermissionIs($permission = '', $boolean = 'and')
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Pilot wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Pilot wherePoendtime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Pilot wherePologintime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Pilot whereRealname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Pilot whereRegistertime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Pilot whereRoleIs($role = '', $team = null, $boolean = 'and')
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Pilot whereToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Pilot whereTxt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Pilot whereUptime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Pilot whereVia($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Pilot whereXiaohaotime($value)
 * @mixin \Eloquent
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\PilotLog[] $logs
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\PilotRedeemCode[] $redeemCodes
 */
class Pilot extends Authenticatable implements MustVerifyEmail
{
    use LaratrustUserTrait;
    use Notifiable;
    public $table = 'pilots';

    const CREATED_AT = 'registertime';
    const UPDATED_AT = 'uptime';

    protected $fillable = [
        'co',
        'callsign',
        'password',
        'via',
        'icq',
        'email',
        'namelog',
        'onlinetime',
        'atctime',
        'xiaohaotime',
        'registertime',
        'logintime',
        'pologintime',
        'poendtime',
        'atclogintime',
        'atcendtime',
        'realname',
        'phone',
        'dizhi',
        'deltatime',
        'atcdeltatime',
        'txt',
        'uptime',
        'token'
    ];

    protected $guarded = [
        'level'
    ];

    protected $hidden = [
        'password',
        'realname',
        'phone',
        'dizhi',
        'token'
    ];

    public function timeStats()
    {
        return $this->hasOne('App\Models\PilotTimeStats','callsign', 'callsign');
    }

    public function platforms()
    {
        return $this->hasMany('App\Models\PilotPlatform','callsign', 'callsign');
    }

    public function logs()
    {
        return $this->hasMany('App\Models\PilotLog','callsign','callsign');
    }

    public function redeemCodes()
    {
        return $this->hasMany('App\Models\PilotRedeemCode','callsign','callsign');
    }

    public function sendEmailVerificationNotification()
    {
        $this->notify(new CustomVerifyEmail());
    }

}
