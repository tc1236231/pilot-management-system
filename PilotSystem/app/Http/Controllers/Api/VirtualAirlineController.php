<?php

namespace App\Http\Controllers\Api;

use App\Services\FlightService;
use App\Services\VirtualAirlineService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class VirtualAirlineController extends Controller
{
    private $vaService;

    public function __construct(VirtualAirlineService $vaService)
    {
        $this->vaService = $vaService;
    }

    public function getPireps($pilotid)
    {
        $pireps = $this->vaService->getPireps($pilotid, 30);
        return response()->json($pireps, 200);
    }
}
