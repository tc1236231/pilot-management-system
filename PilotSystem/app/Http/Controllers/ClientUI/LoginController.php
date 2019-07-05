<?php

namespace App\Http\Controllers\ClientUI;

use App\Models\Enums\PilotLevel;
use App\Models\Platform;
use App\Services\PlatformService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LoginController extends Controller
{
    private $platformService;

    public function __construct(PlatformService $platformService)
    {
        $this->platformService = $platformService;
    }
    public function index(Request $request)
    {
        $user_agent = $request->header('User-Agent');
        $user_ip = $request->ip();
        return view('clientui.login',
            [
                'platforms' => $this->platformService->getAuthorizedPlatforms(),
                'user_agent' => $user_agent,
                'user_ip' => $user_ip,
            ]);
    }

    protected function username() {
        return 'callsign';
    }

    private function originLogin(Request $request, $credentials)
    {
        $authSuccess = Auth::attempt($credentials, $request->has('remember'));

        if($authSuccess) {
            /*
            if(Auth::user()->level <= PilotLevel::BANNED)
            {
                Auth::logout();
                return response()->json(['status' => 'failed', 'message' => '该呼号已被停飞'], Response::HTTP_FORBIDDEN);
            }
            */

            $request->session()->regenerate();
            return response()->json(['status' => 'success', 'message' => '登录成功'], Response::HTTP_OK);
        }
        else
        {
            return
                response()->json([
                    'status' => 'failed',
                    'message' => '呼号或密码错误'
                ], Response::HTTP_FORBIDDEN);
        }
    }

    private function newLogin(Request $request, $credentials) {
        $credentials = array(
            'username' => $credentials[$this->username()],
            'password' => $credentials['password'],
        );
        $authSuccess = Auth::guard('bbs')->attempt($credentials);

        if($authSuccess) {
            $request->session()->regenerate();
            return response()->json(['status' => 'success', 'message' => '登录成功'], Response::HTTP_OK);
        }
        else
        {
            return
                response()->json([
                    'status' => 'failed',
                    'message' => '呼号或密码错误'
                ], Response::HTTP_FORBIDDEN);
        }
    }

    private function cbsLogin(Request $request, $credentials) {
        $credentials = array(
            'username' => $credentials[$this->username()],
            'password' => $credentials['password'],
        );
        $callsign = $credentials[$this->username()];
        if(strlen($callsign) != 4 || !is_numeric($callsign))
            return response()->json(['status' => 'error', 'message' => '呼号格式错误,论坛用户名必须为4位数字呼号']);

        $authSuccess = Auth::guard('cbs')->attempt($credentials);

        if($authSuccess) {
            $request->session()->regenerate();
            return response()->json(['status' => 'success', 'message' => '登录成功'], Response::HTTP_OK);
        }
        else
        {
            return
                response()->json([
                    'status' => 'failed',
                    'message' => '呼号或密码错误'
                ], Response::HTTP_FORBIDDEN);
        }
    }

    public function login(Request $request)
    {
        $credentials = $request->only($this->username(), 'password');
        $platform_request = $request->only('platform');
        $platform = Platform::find($platform_request['platform']);
        switch ($platform_request['platform'])
        {
            case '1':
                return $this->originLogin($request, $credentials);
                break;
            case '2':
                return $this->newLogin($request, $credentials);
                break;
            case '8':
                return $this->cbsLogin($request, $credentials);
                break;
            default:
                return response()->json([
                    'status' => 'failed',
                    'message' => '平台尚未接入完成'
                ], Response::HTTP_FORBIDDEN);
                break;
        }
    }

    public function logout()
    {
        Auth::logout();
        Auth::guard('bbs')->logout();
    }

}
