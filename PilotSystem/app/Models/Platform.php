<?php

namespace App\Models;

use App\Interfaces\Model;

/**
 * App\Models\Platform
 *
 * @property int $id
 * @property string|null $code 三字码
 * @property string|null $name 名称
 * @property string|null $qq QQ群
 * @property string|null $admin 管理呼号
 * @property string|null $kouhao 平台介绍
 * @property string|null $y-1 入住时间
 * @property string|null $shouquan 邦定授权
 * @property string|null $shouquansql 货币兑换授权
 * @property string|null $zhuanhuan 注册平台
 * @property string|null $http 论坛地址
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Platform newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Platform newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Platform query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Platform whereAdmin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Platform whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Platform whereHttp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Platform whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Platform whereKouhao($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Platform whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Platform whereQq($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Platform whereShouquan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Platform whereShouquansql($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Platform whereY1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Platform whereZhuanhuan($value)
 * @mixin \Eloquent
 */
class Platform extends Model
{
    public $table = 'platform';

    protected $fillable = [
        'code',
        'name',
        'qq',
        'admin',
        'kouhao',
        'y-1',
        'shouquan',
        'shouquansql',
        'zhuanhuan',
        'http',
    ];

    protected $guarded = [];

    protected $hidden = [];

}
