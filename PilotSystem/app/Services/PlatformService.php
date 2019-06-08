<?php

namespace App\Services;

use App\Interfaces\Service;
use App\Models\Platform;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Log;

/**
 * Class FlightService
 */
class PlatformService extends Service
{
    public function getAuthorizedPlatforms()
    {
        return Platform::where('shouquan','=','1')->get();
    }

    public function validateUsernamePassword($inputs)
    {
        $platform = strtolower($inputs['platform']);
        try {
            DB::connection('platform_'. $platform)->getPdo();
        } catch (\Exception $e) {
            throw ValidationException::withMessages(['general' => '无数据库连接至'. $platform]);
        }
        $db_conn = DB::connection('platform_'. $platform);
        $verified = false;
        $bind_info = array();
        $bind_info['bbscode'] = $inputs['platform'];

        switch ($platform)
        {
            case 'cfr':
                $uid = $db_conn->table('bbs_common_member')
                    ->where('email', '=', $inputs['email'])
                    ->orWhere('username','=',$inputs['email'])->get('uid');
                if($uid->isEmpty())
                    throw ValidationException::withMessages(['general' => '未找到对应用户名或邮箱']);
                $uid = $uid->first();
                $user_detail = $db_conn->table('uc_members')->where('uid','=',$uid->uid)->get();
                if($user_detail->isEmpty())
                    throw ValidationException::withMessages(['general' => '未找到对应用户']);
                $bind_info['bbsuid'] = $uid->uid;
                $user_detail = $user_detail->first();
                $pw_hash = md5(md5($inputs['password']).$user_detail->salt);
                $verified = ($user_detail->username == $inputs['email'] || $user_detail->email == $inputs['email'])
                    && $pw_hash == $user_detail->password;
                if(!$verified)
                    throw ValidationException::withMessages(['general' => '用户名或密码错误']);
                $bind_info['username'] = $user_detail->username;
                $bind_info['email'] = $user_detail->email;
                break;
            case 'xpl':
                break;
            case 'lpm':
                break;
            default:
                break;
        }

        return array($verified, $bind_info);
    }

    public function validateVirtualAirline($inputs)
    {
        $callsign = \Auth::user()->callsign;
        $platform = 'va';
        try {
            DB::connection('platform_'. $platform)->getPdo();
        } catch (\Exception $e) {
            throw ValidationException::withMessages(['general' => '无数据库连接至'. $platform]);
        }
        $db_conn = DB::connection('platform_'. $platform);

        $va_info = $db_conn->table('phpvms_pilots')->where('lastname','=',$callsign)
            ->first(['password','salt']);

        if(!$va_info)
            throw ValidationException::withMessages(['general' => '没有在航空人生找到此呼号']);

        $verified = $va_info->password == md5($inputs['password'] . $va_info->salt);

        if(!$verified)
            throw ValidationException::withMessages(['general' => '密码错误']);

        return $verified;
    }

    public function getVirtualAirlineInfo($callsign)
    {
        $binded = \DB::table('pilotsdatava')->where('callsign','=',$callsign)
            ->exists();

        if(!$binded)
            return "notbinded";

        $platform = 'va';
        try {
            DB::connection('platform_'. $platform)->getPdo();
        } catch (\Exception $e) {
            return "dberror";
        }
        $db_conn = DB::connection('platform_'. $platform);

        $va_info = $db_conn->table('phpvms_pilots')->where('lastname','=',$callsign)
            ->first();

        return $va_info;
    }
}