<?php

namespace App\Http\Controllers\ClientUI;

use App\Models\ATCLog;
use App\Models\CBSATCLog;
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
        if(!\Auth::user()->isatc)
        {
            return redirect('/clientui/login');
        }
        $restrict = $this->flightService->getRestrictEntry();

        $logs = array();
        if(\Auth::user()->manageATC)
        {
            if(\Auth::guard('cbs')->check())
                $logs = CBSATCLog::orderByDesc('id')->paginate(20);
            else
                $logs = ATCLog::orderByDesc('id')->paginate(20);
        }

        return view('clientui.atc',compact(['restrict','logs']));
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
        $pinfo = array();
        if(\Auth::guard('bbs')->check())
        {
            $pinfo = $this->vaService->getPilotInfo(\Auth::user()->callsign);
        }

        return view('clientui.vaflight', compact('pinfo'));
    }

    public function radar()
    {
        return view('clientui.radar');
    }
}
