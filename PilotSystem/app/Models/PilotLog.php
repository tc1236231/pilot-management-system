<?php

namespace App\Models;

use App\Interfaces\Model;

/**
 * App\Models\PilotLog
 *
 * @property int $id
 * @property string $callsign 操作人
 * @property string $shijian 事件
 * @property string $huobi 货币
 * @property string|null $mubiao 目标对方论坛代码
 * @property string|null $logdate 兑换日期
 * @property-read \App\Models\Pilot $pilot
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PilotLog newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PilotLog newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PilotLog query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PilotLog whereCallsign($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PilotLog whereHuobi($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PilotLog whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PilotLog whereLogdate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PilotLog whereMubiao($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PilotLog whereShijian($value)
 * @mixin \Eloquent
 */
class PilotLog extends Model
{
    public $table = 'pilotslog';
    const CREATED_AT = 'logdate';
    const UPDATED_AT = null;

    protected $fillable = [
        'callsign',
        'shijian',
        'huobi',
        'mubiao',
        'logdate',
    ];

    protected $guarded = [];

    protected $hidden = [];

    public function pilot()
    {
        return $this->belongsTo('App\Models\Pilot','callsign','callsign');
    }

}
