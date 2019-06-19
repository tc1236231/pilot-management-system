<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\NewUserDetail
 *
 * @property int $uid
 * @property string $realname
 * @property int $gender
 * @property int $birthyear
 * @property int $birthmonth
 * @property int $birthday
 * @property string $constellation
 * @property string $zodiac
 * @property string $telephone
 * @property string $mobile
 * @property string $idcardtype
 * @property string $idcard
 * @property string $address
 * @property string $zipcode
 * @property string $nationality
 * @property string $birthprovince
 * @property string $birthcity
 * @property string $birthdist
 * @property string $birthcommunity
 * @property string $resideprovince
 * @property string $residecity
 * @property string $residedist
 * @property string $residecommunity
 * @property string $residesuite
 * @property string $graduateschool
 * @property string $company
 * @property string $education
 * @property string $occupation
 * @property string $position
 * @property string $revenue
 * @property string $affectivestatus
 * @property string $lookingfor
 * @property string $bloodtype
 * @property string $height
 * @property string $weight
 * @property string $alipay
 * @property string $icq
 * @property string $qq
 * @property string $yahoo
 * @property string $msn
 * @property string $taobao
 * @property string $site
 * @property string $bio
 * @property string $interest
 * @property string $field1 连飞资格 0未获得 1已获得 2停飞
 * @property int $field2 飞行时长（秒）
 * @property string $field3 管资 0未获 1已获得 3地面 4塔台 5离场 6进近 7区调 8初教 9中教 10高教 11管理 12局长
 * @property int $field4 管制时长（秒）
 * @property string $field5 月度资格审核 00=未认证 小于当前月显示过期
 * @property string $field6
 * @property string $field7
 * @property string $field8
 * @property string $pologintime 飞行员连线时间
 * @property string $poendtime 飞行员断线时间
 * @property string $atclogintime 管制连线时间
 * @property string $atcendtime 管制断线时间
 * @property int $deltatime 飞行员增量时间（秒）
 * @property int $atcdeltatime ATC增量时间（秒）
 * @property-read \App\Models\NewUser $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\NewUserDetail newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\NewUserDetail newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\NewUserDetail query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\NewUserDetail whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\NewUserDetail whereAffectivestatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\NewUserDetail whereAlipay($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\NewUserDetail whereAtcdeltatime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\NewUserDetail whereAtcendtime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\NewUserDetail whereAtclogintime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\NewUserDetail whereBio($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\NewUserDetail whereBirthcity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\NewUserDetail whereBirthcommunity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\NewUserDetail whereBirthday($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\NewUserDetail whereBirthdist($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\NewUserDetail whereBirthmonth($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\NewUserDetail whereBirthprovince($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\NewUserDetail whereBirthyear($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\NewUserDetail whereBloodtype($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\NewUserDetail whereCompany($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\NewUserDetail whereConstellation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\NewUserDetail whereDeltatime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\NewUserDetail whereEducation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\NewUserDetail whereField1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\NewUserDetail whereField2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\NewUserDetail whereField3($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\NewUserDetail whereField4($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\NewUserDetail whereField5($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\NewUserDetail whereField6($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\NewUserDetail whereField7($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\NewUserDetail whereField8($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\NewUserDetail whereGender($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\NewUserDetail whereGraduateschool($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\NewUserDetail whereHeight($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\NewUserDetail whereIcq($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\NewUserDetail whereIdcard($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\NewUserDetail whereIdcardtype($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\NewUserDetail whereInterest($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\NewUserDetail whereLookingfor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\NewUserDetail whereMobile($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\NewUserDetail whereMsn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\NewUserDetail whereNationality($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\NewUserDetail whereOccupation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\NewUserDetail wherePoendtime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\NewUserDetail wherePologintime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\NewUserDetail wherePosition($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\NewUserDetail whereQq($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\NewUserDetail whereRealname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\NewUserDetail whereResidecity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\NewUserDetail whereResidecommunity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\NewUserDetail whereResidedist($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\NewUserDetail whereResideprovince($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\NewUserDetail whereResidesuite($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\NewUserDetail whereRevenue($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\NewUserDetail whereSite($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\NewUserDetail whereTaobao($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\NewUserDetail whereTelephone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\NewUserDetail whereUid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\NewUserDetail whereWeight($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\NewUserDetail whereYahoo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\NewUserDetail whereZipcode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\NewUserDetail whereZodiac($value)
 * @mixin \Eloquent
 */
class NewUserDetail extends Model
{
    public $connection = 'platform_bbs';
    public $table = 'bbs_common_member_profile';
    public $primaryKey = 'uid';
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\NewUser','uid', 'uid');
    }

}