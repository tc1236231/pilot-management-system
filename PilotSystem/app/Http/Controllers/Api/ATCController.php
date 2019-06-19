<?php

namespace App\Http\Controllers\Api;

use App\Models\ATCLog;
use App\Models\Enums\ATCLevel;
use App\Models\Enums\PilotFlightPermission;
use App\Models\NewUser;
use App\Services\FlightService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;

class ATCController extends Controller
{
    private $flightService;

    public function __construct(FlightService $flightService)
    {
        $this->flightService = $flightService;
    }

    public function createATIS()
    {
        $freq = Input::get('freq', '');
        $txt = Input::get('txt', '');

        if (empty($freq) || empty($txt)) {
            return response()->json('Input Error', 400);
        }

        if(!preg_match('/^[0-9][0-9][0-9]\.[0-9][0-9][0-9]/', $freq)) {
            return response()->json('Input Error', 400);
        }

        DB::table('atis')->where('frequency', '=', $freq)->delete();
        DB::table('atis')->insert(['frequency' => $freq, 'txt'=>$txt, 'uptime'=>Carbon::now()]);

        return response()->json('success', 200);
    }

    public function getATIS()
    {
        $freq = Input::get('freq', '');
        if (empty($freq)) {
            return response()->json('Input Error', 400);
        }

        if(!preg_match('/^[0-9][0-9][0-9]\.[0-9][0-9][0-9]/', $freq)) {
            return response()->json('Input Error', 400);
        }

        $result = DB::table('atis')->where('frequency', '=', $freq)->first();
        if(!$result)
            return response()->json('', 404);
        return response()->json($result->txt, 200);
    }

    public function updateRestrictStatus()
    {
        $status = Input::get('status', '-1');
        if ($status == '-1') {
            return response()->json('Input Error', 400);
        }
        $status = intval($status);

        $this->flightService->updateRestrictEntry($status);
        return response()->json('success', 200);
    }

    public function queryCallsignStatus()
    {
        $callsign = Input::get('callsign','');
        if(empty($callsign))
            return response()->json('呼号不能为空',400);

        $user = NewUser::where('username','=',$callsign)->first();
        if(!$user)
            return response()->json('查不到该呼号信息',404);

        $current_admin_level = \Auth::user()->detail->field3;
        if(!\Auth::user()->manageATC)
            return response()->json('无权限',401);

        $actions = array();
        if($user->banned)
            array_push($actions, 'unban');
        if(!$user->banned)
            array_push($actions, 'ban');
        if($user->detail->field3 <= 7 && $current_admin_level > 10 && $user->detail->field3 != 0)
            array_push($actions, 'mod');

        $flight_perm = PilotFlightPermission::label($user->detail->field1);
        $atc_level = ATCLevel::label($user->detail->field3);

        return response()->json(['status' => 'success', 'callsign' => $callsign, 'actions' => $actions, 'flight_perm' => $flight_perm, 'atc_level' => $atc_level], 200);
    }

    public function banCallsign()
    {
        $callsign = Input::get('callsign','');
        if(empty($callsign))
            return response()->json('呼号不能为空',400);

        $user = NewUser::where('username','=',$callsign)->first();
        if(!$user)
            return response()->json('查不到该呼号信息',404);

        if($user->banned)
            return response()->json('该呼号已经被封禁',400);

        if(!\Auth::user()->manageATC)
            return response()->json('无权限',401);

        $user->detail->field1 = 2;
        $user->detail->save();

        ATCLog::create(['callsign' => $callsign, 'content' => '停飞封禁', 'admin' => \Auth::user()->callsign, 'time' => Carbon::now()]);

        return response()->json(['status' => 'success'], 200);
    }

    public function unbanCallsign()
    {
        $callsign = Input::get('callsign','');
        if(empty($callsign))
            return response()->json('呼号不能为空',400);

        $user = NewUser::where('username','=',$callsign)->first();
        if(!$user)
            return response()->json('查不到该呼号信息',404);

        if(!$user->banned)
            return response()->json('该呼号未被封禁',400);

        if(!\Auth::user()->manageATC)
            return response()->json('无权限',401);

        $user->detail->field1 = 0;
        $user->detail->save();

        ATCLog::create(['callsign' => $callsign, 'content' => '解封', 'admin' => \Auth::user()->callsign, 'time' => Carbon::now()]);

        return response()->json(['status' => 'success'], 200);
    }

    public function modCallsign()
    {
        $callsign = Input::get('callsign','');
        $level = Input::get('level','');
        if(empty($callsign) || !is_numeric($level))
            return response()->json('输入有误',400);

        $user = NewUser::where('username','=',$callsign)->first();
        if(!$user)
            return response()->json('查不到该呼号信息',404);

        if($user->banned)
            return response()->json('该呼号已经被封禁',400);

        $current_admin_level = \Auth::user()->detail->field3;
        if(!\Auth::user()->manageATC || $current_admin_level <= 10 || $user->detail->field3 == 0)
            return response()->json('无权限',401);

        $old_level_txt = ATCLevel::label($user->detail->field3);

        $user->detail->field3 = $level;
        $user->detail->save();

        $new_level_txt = ATCLevel::label($level);

        ATCLog::create(['callsign' => $callsign, 'content' => '变更权限'.$old_level_txt.'->'.$new_level_txt,'admin' => \Auth::user()->callsign, 'time' => Carbon::now()]);

        return response()->json(['status' => 'success'], 200);
    }
}
