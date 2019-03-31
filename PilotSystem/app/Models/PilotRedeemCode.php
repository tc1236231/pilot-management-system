<?php

namespace App\Models;

use App\Interfaces\Model;

/**
 * App\Models\PilotRedeemCode
 *
 * @property int $id
 * @property string $callsign 兑换有效人
 * @property int|null $amount 兑换数量
 * @property string $privatekey 兑换码
 * @property int|null $yesno 是否有效
 * @property string|null $keydate 兑换日期
 * @property string|null $leixing
 * @property string|null $cishu 统计次数
 * @property string|null $keybeizhu 奖励备注
 * @property-read \App\Models\Pilot $pilot
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PilotRedeemCode newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PilotRedeemCode newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PilotRedeemCode query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PilotRedeemCode whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PilotRedeemCode whereCallsign($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PilotRedeemCode whereCishu($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PilotRedeemCode whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PilotRedeemCode whereKeybeizhu($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PilotRedeemCode whereKeydate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PilotRedeemCode whereLeixing($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PilotRedeemCode wherePrivatekey($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PilotRedeemCode whereYesno($value)
 * @mixin \Eloquent
 */
class PilotRedeemCode extends Model
{
    public $table = 'pilotskey';
    public $timestamps = false;

    protected $fillable = [
        'callsign',
        'amount',
        'privatekey',
        'keydate',
        'leixing',
        'cishu',
        'keybeizhu',
        'yesno',
    ];

    protected $guarded = [];

    protected $hidden = [];

    public function pilot()
    {
        return $this->belongsTo('App\Models\Pilot','callsign','callsign');
    }

}
