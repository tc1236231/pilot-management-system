<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laratrust\Traits\LaratrustUserTrait;


/**
 * App\Models\ApiUser
 *
 * @property int $id
 * @property string $name
 * @property string|null $description
 * @property string $ip
 * @property string $api_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Permission[] $permissions
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Role[] $roles
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ApiUser newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ApiUser newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ApiUser orWherePermissionIs($permission = '')
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ApiUser orWhereRoleIs($role = '', $team = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ApiUser query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ApiUser whereApiToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ApiUser whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ApiUser whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ApiUser whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ApiUser whereIp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ApiUser whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ApiUser wherePermissionIs($permission = '', $boolean = 'and')
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ApiUser whereRoleIs($role = '', $team = null, $boolean = 'and')
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ApiUser whereUpdatedAt($value)
 * @mixin \Eloquent
 */
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
