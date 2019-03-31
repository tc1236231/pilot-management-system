<?php

namespace App\Http\Controllers\Api;

use App\Models\Enums\PilotLevel;
use App\Models\Pilot;
use http\Env\Response;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Input;

class AuthController extends Controller
{
    //
    public function verifyCallsignPassword()
    {
        $callsign = Input::get('callsign','');
        $password = Input::get('password','');

        $pilot = Pilot::where('callsign', '=', $callsign)->first();
        if(!$pilot)
            return response()->json(['status' => 'error', 'message' => '呼号不存在']);

        if (!Hash::check($password, $pilot->password))
            return response()->json(['status' => 'error', 'message' => '呼号密码错误']);

        if ($pilot->level == PilotLevel::BANNED)
            return response()->json(['status' => 'error', 'message' => '呼号停飞']);

        return response()->json(['status' => 'success', 'message' => '']);
    }
}
