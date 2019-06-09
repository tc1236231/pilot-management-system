<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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