<?php

namespace App\Models;

use App\Interfaces\Model;

/**
 * App\Models\PilotTimeStats
 *
 * @property string $callsign 呼号
 * @property int|null $m1
 * @property int|null $m2
 * @property int|null $m3
 * @property int|null $m4
 * @property int|null $m5
 * @property int|null $m6
 * @property int|null $m7
 * @property int|null $m8
 * @property int|null $m9
 * @property int|null $m10
 * @property int|null $m11
 * @property int|null $m12
 * @property-read \App\Models\Pilot $pilot
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PilotTimeStats newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PilotTimeStats newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PilotTimeStats query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PilotTimeStats whereCallsign($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PilotTimeStats whereM1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PilotTimeStats whereM10($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PilotTimeStats whereM11($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PilotTimeStats whereM12($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PilotTimeStats whereM2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PilotTimeStats whereM3($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PilotTimeStats whereM4($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PilotTimeStats whereM5($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PilotTimeStats whereM6($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PilotTimeStats whereM7($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PilotTimeStats whereM8($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PilotTimeStats whereM9($value)
 * @mixin \Eloquent
 */
class PilotTimeStats extends Model
{
    public $table = 'userdeal';

    protected $fillable = [];

    protected $guarded = [
        'callsign',
        "m1",
        "m2",
        "m3",
        "m4",
        "m5",
        "m6",
        "m7",
        "m8",
        "m9",
        "m10",
        "m11",
        "m12",
    ];

    protected $hidden = [];

    public function pilot()
    {
        return $this->belongsTo('App\Models\Pilot','callsign', 'callsign');
    }
}
