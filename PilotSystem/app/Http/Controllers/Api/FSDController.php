<?php

namespace App\Http\Controllers\Api;

use App\Models\CBSUser;
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
            'source' => 'required|string'
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
                switch ($input['source'])
                {
                    case "COC":
                        $authed = Auth::guard("bbs")->validate($credentials);
                        $user = NewUser::where("username", "=", $input['callsign'])->first();
                        break;
                    case "CBS":
                        $authed = Auth::guard("cbs")->validate($credentials);
                        $user = CBSUser::where("username", "=", $input['callsign'])->first();
                        break;
                    default:
                        $authed = Auth::guard("bbs")->validate($credentials);
                        $user = NewUser::where("username", "=", $input['callsign'])->first();
                        break;
                }
                if(!$authed)
                    return response()->json(["status" => "WRONG_PASSWORD"], 200);
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
                $authed = Auth::guard("cbs")->validate($credentials);
                if(!$authed)
                    return response()->json(["status" => "WRONG_PASSWORD"], 200);
                $user = CBSUser::where("username", "=", $input['callsign'])->first();
                if($user->banned)
                    return response()->json(["status" => "BANNED"], 200);

                $code = $platform_code;
                try
                {
                    $code = $user->detail->company;
                    if(strlen($code) != 3)
                        throw new \Exception('Invalid company code');
                }
                catch(\Exception $e)
                {
                    $code = $platform_code;
                }
                return response()->json(["status" => "PILOT", "code" => $code], 200);
                break;
            default:
                $simLabel = substr($input['platform'], 0, 1);
                if($simLabel == "-")
                {
                    $authed = Auth::guard("bbs")->validate($credentials);
                    if(!$authed)
                        return response()->json(["status" => "WRONG_PASSWORD"], 200);
                    $user = NewUser::where("username", "=", $input['callsign'])->first();
                    if($user->banned)
                        return response()->json(["status" => "BANNED"], 200);
                    return response()->json(["status" => "SIM"], 200);
                }
                break;
        }


        //set login time
    }

    public function logout()
    {

    }
}
