<?php

namespace App\Services;

use App\Interfaces\Service;
use DB;

class VirtualAirlineService extends Service
{
    public function __construct()
    {
    }

    public function getAirlines()
    {
        try {
            DB::connection('platform_va')->getPdo();
        } catch (\Exception $e) {
            return array();
        }
        $db_conn = DB::connection('platform_va');

        $airlines = $db_conn->table('phpvms_airlines')->where('enabled','=', 1)->get();

        return $airlines;
    }

    public function getPireps($pilotid, $limit)
    {
        try {
            DB::connection('platform_va')->getPdo();
        } catch (\Exception $e) {
            return array();
        }
        $db_conn = DB::connection('platform_va');

        $pireps = $db_conn->table('phpvms_pireps')->where('pilotid','=', $pilotid)->orderByDesc('pirepid')
            ->limit($limit)
            ->get(["pirepid", "code", "flightnum", "depicao", "arricao", "submitdate", "accepted"]);

        return $pireps;
    }

    public function getPilotInfo($callsign)
    {
        try {
            DB::connection('platform_va')->getPdo();
        } catch (\Exception $e) {
            return array();
        }
        $db_conn = DB::connection('platform_va');

        $info = $db_conn->table('phpvms_pilots')->where('lastname','=', $callsign)
            ->first();

        return $info;
    }

    public function getAvailableHubs($code)
    {
        try {
            DB::connection('platform_va')->getPdo();
        } catch (\Exception $e) {
            return array();
        }
        $db_conn = DB::connection('platform_va');

        $hubs = $db_conn->table('phpvms_airports_hub')->where('country','=', $code)->where('off','=',1)
            ->get();

        return $hubs;
    }

    public function getAvailableAircrafts($code)
    {
        try {
            DB::connection('platform_va')->getPdo();
        } catch (\Exception $e) {
            return array();
        }
        $db_conn = DB::connection('platform_va');

        $acs = $db_conn->table('phpvms_aircraft')->where('icao','=', $code)->where('enabled','=',1)
            ->get();

        return $acs;
    }

    public function getAvailableAltitudes()
    {
        try {
            DB::connection('platform_va')->getPdo();
        } catch (\Exception $e) {
            return array();
        }
        $db_conn = DB::connection('platform_va');

        $levels = $db_conn->table('php_level')
            ->get();

        return $levels;
    }

    public function getAircraftTrackers($limit = 15)
    {
        try {
            DB::connection('platform_va')->getPdo();
        } catch (\Exception $e) {
            return array();
        }
        $db_conn = DB::connection('platform_va');

        $aircraftTrackers = $db_conn->table('aircraft_tracker')->orderByDesc('uptime')
            ->limit($limit)->get();

        return $aircraftTrackers;
    }

    public function getFOQAFiles()
    {
        try {
            DB::connection('platform_va')->getPdo();
        } catch (\Exception $e) {
            return array();
        }
        $db_conn = DB::connection('platform_va');

        $foqaFiles = $db_conn->table('aircraft_mk')->get();

        return $foqaFiles;
    }
}