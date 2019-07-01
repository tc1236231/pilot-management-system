<?php

namespace App\Http\Controllers\Api;

use App\Models\NewUser;
use App\Services\VirtualAirlineService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class FSDController extends Controller
{
    private $vaService;

    public function __construct(VirtualAirlineService $vaService)
    {
        $this->vaService = $vaService;
    }

    //
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'platform' => 'required|string',
            'callsign' => 'required|string',
            'password' => 'required|string',
        ]);
        $input = $validator->validate();

        $platform_code = substr($input['platform'], 0, 3);
        $credentials = array("username" => $input['callsign'], "password" => $input["password"]);
        $authed = false;
        $is_atc = false;
        switch ($platform_code)
        {
            case "ATC":
                $is_atc = true;
                $authed = Auth::guard("bbs")->validate($credentials);
                if(!$authed)
                    return response()->json(["status" => "WRONG_PASSWORD"], 200);
                $user = NewUser::where("username", "=", $input['callsign'])->first();
                if($user->banned)
                    return response()->json(["status" => "BANNED"], 200);
                return response()->json(["status" => "ATC", "level" => ($user->atclevel + 1)], 200);
                break;
            case "COC":
                $authed = Auth::guard("bbs")->validate($credentials);
                if(!$authed)
                    return response()->json(["status" => "WRONG_PASSWORD"], 200);
                $user = NewUser::where("username", "=", $input['callsign'])->first();
                if($user->banned)
                    return response()->json(["status" => "BANNED"], 200);
                $pinfo = $this->vaService->getPilotInfo($input["callsign"]);
                $code = $platform_code;
                if($pinfo)
                    $code = $pinfo->code;
                return response()->json(["status" => "PILOT", "code" => $code], 200);
                break;
            case "CBS":
                break;
            default:
                break;
        }


        //set login time
    }

    public function logout()
    {

    }
}
