<?php

namespace App\Models;

use App\Interfaces\Model;

/**
 * App\Models\PilotSearchLog
 *
 * @property int $id
 * @property string $co 所属平台
 * @property string $searchid 飞行员呼号ID
 * @property string $level 呼号类型
 * @property string $namelog 呼号状态
 * @property string $txt 内容
 * @property string $time 时间
 * @property string $admin_callsign 操作人ID
 * @property-read \App\Models\Pilot $pilot
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PilotSearchLog newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PilotSearchLog newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PilotSearchLog query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PilotSearchLog whereCo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PilotSearchLog whereHhid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PilotSearchLog whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PilotSearchLog whereLevel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PilotSearchLog whereNamelog($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PilotSearchLog whereSearchid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PilotSearchLog whereTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PilotSearchLog whereTxt($value)
 * @mixin \Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PilotSearchLog whereAdminCallsign($value)
 */
class PilotSearchLog extends Model
{
    public $table = 'pilots_search_log';
    const CREATED_AT = 'time';
    const UPDATED_AT = null;

    protected $fillable = [
        'co',
        'searchid',
        'level',
        'namelog',
        'txt',
        'time',
        'admin_callsign'
    ];

    protected $guarded = [];

    protected $hidden = [];

    public function pilot()
    {
        return $this->belongsTo('App\Models\Pilot','searchid','callsign');
    }

    public function admin()
    {
        return $this->belongsTo('App\Models\Pilot','admin_callsign','callsign');
    }

}
