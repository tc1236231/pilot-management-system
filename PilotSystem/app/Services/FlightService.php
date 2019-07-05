<?php

namespace App\Services;

use App\Interfaces\Service;
use App\Models\Platform;
use Carbon\Carbon;
use DB;
use Exception;

class FlightService extends Service
{
    public function __construct()
    {

    }

    public function getPlatformId($code)
    {
        $platform = Platform::where('code','=',$code)->first();
        if(!$platform)
            return -1;
        return $platform->id;
    }

    public function getRestrictFlight()
    {
        $status = DB::table('sv_config')->where('type','=',3)
            ->where('platform_ID','=',$this->getPlatformId(\Auth::user()->platform))
            ->first('ip');
        if(!$status)
            return false;
        return $status->ip == 1;
    }

    public function getRestrictEntry()
    {
        $status = DB::table('sv_config')->where('type','=',3)
            ->where('platform_ID','=',$this->getPlatformId(\Auth::user()->platform))
            ->first();
        return $status;
    }

    public function updateRestrictEntry($status)
    {
        if($status > 1) {
            throw new Exception('invalid status');
        }

        DB::table('sv_config')->where('type','=',3)
            ->where('platform_ID','=',$this->getPlatformId(\Auth::user()->platform))
            ->update(['ip' => $status, 'ussvname' => \Auth::user()->callsign, 'uptime' => Carbon::now()]);
    }

    public function getFlightServers()
    {
        $servers = DB::table('sv_config')->where('type','=',1)
            ->where('platform_ID','=',$this->getPlatformId(\Auth::user()->platform))
            ->get();
        return $servers;
    }
}