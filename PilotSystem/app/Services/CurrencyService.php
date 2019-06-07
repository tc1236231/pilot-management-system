<?php

namespace App\Services;

use App\Interfaces\Service;
use App\Models\PilotLog;
use App\Models\PilotRedeemCode;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Log;

/**
 * Class FlightService
 */
class CurrencyService extends Service
{
    public static function generateApiKey(): string
    {
        $key = substr(sha1(time().mt_rand()), 0, 20);
        return $key;
    }

    public function createRedeemCode($inputs)
    {
        $creater_callsign = \Auth::user()->callsign;
        if(!isset($creater_callsign) || empty($creater_callsign))
            throw ValidationException::withMessages(['general' => '验证失败']);
        $key = date("Y-m-d H:i") . "_" . strtoupper(substr(sha1(time().mt_rand()), 0, 20))
            . "_" . $creater_callsign;
        $inputs['privatekey'] = $key;
        $inputs['yesno'] = 1;
        $r_code = PilotRedeemCode::create($inputs);
        return $r_code;
    }

    public function useRedeemCode($inputs)
    {
        $key = $inputs['coupon'];
        $query = \Auth::user()->redeemCodes()->where('privatekey','=',$key)->where('yesno','=','1')->first();

        if(!$query)
            throw ValidationException::withMessages(['general' => 'KEY无效']);

        $amount = $query->amount;
        if($amount < 1)
            throw ValidationException::withMessages(['general' => 'KEY无效']);

        $platform = $inputs['platform'];

        $platform_bind_info = \Auth::user()->platforms()->with('platform')->whereHas('platform',function ($query) use ($platform) {
            $query->where('shouquan', '=', 1)->where('code','=',$platform);
        });
        if(!$platform_bind_info->exists())
        {
            throw ValidationException::withMessages(['general' => '平台无效或停止兑换']);
        }
        $platform_bind_info = $platform_bind_info->first();

        $platform = strtolower($inputs['platform']);
        try {
            DB::connection('platform_'. $platform)->getPdo();
        } catch (\Exception $e) {
            throw ValidationException::withMessages(['general' => '无数据库连接至'. $platform]);
        }
        $db_conn = DB::connection('platform_'. $platform);
        $result = -1;

        switch ($platform)
        {
            case 'cfr':
                $result = $db_conn->table('bbs_common_member_count')
                    ->where('uid', '=', $platform_bind_info->bbsuid)
                    ->increment('extcredits4', $amount);
                break;
            case 'xpl':
                break;
            case 'lpm':
                break;
            default:
                break;
        }

        $query->update(array('yesno' => '0', 'keydate' => Carbon::now()));

        $log = array(
            'callsign' => \Auth::user()->callsign,
            'shijian' => '奖励兑换',
            'huobi' => $amount,
            'mubiao' => $inputs['platform']
        );
        PilotLog::create($log);

        return $result;
    }
}