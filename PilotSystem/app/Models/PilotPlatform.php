<?php

namespace App\Models;

use App\Interfaces\Model;

/**
 * App\Models\PilotPlatform
 *
 * @property int $id
 * @property string $callsign 呼号
 * @property string $bbscode 绑定网站代码
 * @property string $bbsuid 邦定ID
 * @property string $username 对应用户名
 * @property string $email 对应注册信息
 * @property-read \App\Models\Pilot $pilot
 * @property-read \App\Models\Platform $platform
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PilotPlatform newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PilotPlatform newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PilotPlatform query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PilotPlatform whereBbscode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PilotPlatform whereBbsuid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PilotPlatform whereCallsign($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PilotPlatform whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PilotPlatform whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PilotPlatform whereUsername($value)
 * @mixin \Eloquent
 */
class PilotPlatform extends Model
{
    public $table = 'pilotsdata';
    public $timestamps = false;

    protected $fillable = [
        'callsign',
        'bbscode',
        'bbsuid',
        'username',
        'email',
    ];

    protected $guarded = [];

    protected $hidden = [];

    public function pilot()
    {
        return $this->belongsTo('App\Models\Pilot','callsign', 'callsign');
    }

    public function platform()
    {
        return $this->belongsTo('App\Models\Platform', 'bbscode', 'code');
    }
}
