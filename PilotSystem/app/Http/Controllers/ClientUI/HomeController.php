<?php

namespace App\Http\Controllers\ClientUI;

use App\Services\FlightService;
use App\Services\VirtualAirlineService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;

class HomeController extends Controller
{
    private $flightService;
    private $vaService;

    public function __construct(FlightService $flightService, VirtualAirlineService $vaService)
    {
        $this->flightService = $flightService;
        $this->vaService = $vaService;
    }

    public function index()
    {
        return view('clientui.index');
    }

    public function vip()
    {
        if(\Auth::guard('web')->check())
        {
            return view('clientui.oldforbidden');
        }
        return view('clientui.vip');
    }

    public function news($type)
    {
        switch ($type)
        {
            case "qq":
                return view('clientui.news.qq');
                break;
            case "zhibo":
                return view('clientui.news.zhibo');
                break;
            case "airlines":
                return view('clientui.news.airlines');
                break;
        }
    }

    public function flightcenter()
    {
        if(\Auth::guard('web')->check())
        {
            return view('clientui.oldforbidden');
        }
        return view('clientui.flightcenter');
    }

    public function atc()
    {
        $restrict = $this->flightService->getRestrictEntry();

        return view('clientui.atc',compact('restrict'));
    }

    public function voice()
    {
        return view('clientui.voice');
    }

    public function faq()
    {
        return view('clientui.faq');
    }

    public function vaflight()
    {
        if(\Auth::guard('web')->check())
        {
            return view('clientui.oldforbidden');
        }
        $pinfo = $this->vaService->getPilotInfo(\Auth::user()->callsign);

        return view('clientui.vaflight', compact('pinfo'));
    }
}
