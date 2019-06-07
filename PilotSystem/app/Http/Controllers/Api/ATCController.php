<?php

namespace App\Http\Controllers\Api;

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
}
