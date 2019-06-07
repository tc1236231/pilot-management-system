<?php

namespace App\Services;

use App\Interfaces\Service;
use Carbon\Carbon;
use DB;
use Exception;

class FlightService extends Service
{
    public function __construct()
    {

    }

    public function getRestrictFlight()
    {
        $status = DB::table('sv_config')->where('Id','=',5)->first('ip');
        return $status->ip == 1;
    }

    public function getRestrictEntry()
    {
        $status = DB::table('sv_config')->where('Id','=',5)->first();
        return $status;
    }

    public function updateRestrictEntry($status)
    {
        if($status > 1) {
            throw new Exception('invalid status');
        }

        DB::table('sv_config')->where('Id','=',5)->update(['ip' => $status, 'ussvname' => \Auth::user()->callsign, 'uptime' => Carbon::now()]);
    }

    public function getFlightServers()
    {
        $servers = DB::table('sv_config')->where('type','=',1)->get();
        return $servers;
    }
}