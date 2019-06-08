<?php

namespace App\Http\Controllers\ClientUI;

use App\Models\Enums\PilotLevel;
use App\Services\PlatformService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    private $platformService;

    public function __construct(PlatformService $platformService)
    {
        $this->platformService = $platformService;
    }
    public function index()
    {
        return view('clientui.login',
            [
                'platforms' => $this->platformService->getAuthorizedPlatforms(),
            ]);
    }

    protected function username() {
        return 'callsign';
    }

    public function login(Request $request)
    {
        $credentials = $request->only($this->username(), 'password');
        $authSuccess = Auth::attempt($credentials, $request->has('remember'));

        if($authSuccess) {

            if(Auth::user()->level <= PilotLevel::BANNED)
            {
                Auth::logout();
                return response()->json(['status' => 'failed', 'message' => '该呼号已被停飞'], Response::HTTP_FORBIDDEN);
            }

            $request->session()->regenerate();
            return response()->json(['status' => 'success', 'message' => '登录成功'], Response::HTTP_OK);
        }

        return
            response()->json([
                'status' => 'failed',
                'message' => '呼号或密码错误'
            ], Response::HTTP_FORBIDDEN);
    }

}
