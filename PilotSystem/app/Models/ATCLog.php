<?php
namespace App\Models;


use App\Interfaces\Model;

/**
 * App\Models\ATCLog
 *
 * @property int $id
 * @property string $callsign
 * @property string $content
 * @property string $admin
 * @property \Illuminate\Support\Carbon $time
 * @property-read \App\Models\NewUser $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ATCLog newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ATCLog newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ATCLog query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ATCLog whereAdmin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ATCLog whereCallsign($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ATCLog whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ATCLog whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ATCLog whereTime($value)
 * @mixin \Eloquent
 */
class ATCLog extends Model
{
    public $connection = 'platform_bbs';
    public $table = 'userdeal_atc_log';
    const CREATED_AT = 'time';
    const UPDATED_AT = null;

    protected $fillable = [
        'callsign',
        'content',
        'admin',
        'time',
    ];

    protected $guarded = [];

    protected $hidden = [];

    public function user()
    {
        return $this->belongsTo('App\Models\NewUser','username','callsign');
    }

}
