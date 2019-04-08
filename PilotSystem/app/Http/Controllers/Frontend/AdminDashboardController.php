<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdminUpdateProfileRequest;
use App\Http\Requests\CreateRedeemCodesRequest;
use App\Models\Enums\PilotNameLog;
use App\Models\Pilot;
use App\Models\PilotRedeemCode;
use App\Models\PilotSearchLog;
use App\Models\Platform;
use App\Services\CurrencyService;
use App\Services\PlatformService;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Input;
use Illuminate\Validation\ValidationException;

class AdminDashboardController extends Controller
{
    private $currencyService;
    private $platformService;

    public function __construct(CurrencyService $currencyService, PlatformService $platformService)
    {
        $this->currencyService = $currencyService;
        $this->platformService = $platformService;
    }

    public function index()
    {
        return view('dashboard.admin.manage');
    }

    public function manage()
    {
        $callsign = Input::get('callsign', '');
        $pilot = Pilot::where('callsign', '=', $callsign)->first();
        if($pilot)
        {
            return view('dashboard.admin.manage', [
                'pilot' => $pilot,
                'platforms' => Platform::where('shouquan','=','1')->get(),
                'user_platforms' => $pilot->platforms,
                'getlevel' => \Auth::user()->level,
                'va' => $this->platformService->getVirtualAirlineInfo($callsign),
            ]);
        }
        else
        {
            \Session::now('status', '该呼号不存在');
            \Session::now('alert-class', 'alert-danger');
            return $this->index();
        }
    }

    public function updateProfile(AdminUpdateProfileRequest $request)
    {
        $attrs = $request->all();
        if(array_key_exists('co', $attrs))
        {
            if($request->user()->level != \PilotLevel::SUPER_ADMIN)
            {
                throw ValidationException::withMessages(array('general' => '无权限修改平台'));
            }
        }
        $targetPilot = Pilot::where('callsign', '=', $attrs['callsign'])->first();
        if($targetPilot->level >= $request->user()->level && $request->user()->level != \PilotLevel::SUPER_ADMIN)
        {
            throw ValidationException::withMessages(array('general' => '无权限修改该呼号,你的等级不足'));
        }
        if(!array_key_exists(($attrs['level']), \PilotLevel::getOptions($targetPilot->level)))
        {
            throw ValidationException::withMessages(array('general' => '无权限修改该呼号类型至'. \PilotLevel::label($attrs['level'])));
        }
        if(!in_array(($attrs['namelog']), PilotNameLog::getOptions($targetPilot->level)))
        {
            throw ValidationException::withMessages(array('general' => '无权限修改该呼号状态至'. $attrs['namelog']));
        }
        if($attrs['level'] == 0 && empty($attrs['txt']))
        {
            throw ValidationException::withMessages(array('general' => ' 封号需备注理由'));
        }

        if(!empty($attrs['co']))
            $targetPilot->co = $attrs['co'];
        $targetPilot->namelog = $attrs['namelog'];
        $targetPilot->level = $attrs['level'];
        if(!empty($attrs['txt']))
            $targetPilot->txt =  $attrs['txt'] . " | "  . $targetPilot->txt;
        $targetPilot->save();

        $logs = [
            'co' => $targetPilot->co,
            'searchid' => $targetPilot->callsign,
            'level' => $targetPilot->level,
            'namelog' => $targetPilot->namelog,
            'txt' => empty($attrs['txt']) ? '' : $attrs['txt'],
            'admin_callsign' => $request->user()->callsign
        ];
        PilotSearchLog::create($logs);

        $request->session()->flash('status', '修改成功!');
        $request->session()->flash('alert-class', 'alert-success');
        return redirect()->back();
    }

    public function redeem()
    {
        return view('dashboard.admin.redeem', [
            'all_coupons' => PilotRedeemCode::orderByDesc('id')->paginate(20),
        ]);
    }

    public function createRedeem(CreateRedeemCodesRequest $request)
    {
        $attrs = $request->all();
        $callsigns = explode('.', $attrs['callsign_str']);
        $not_callsigns = array();
        foreach($callsigns as $callsign)
        {
            $callsign_exists = Pilot::where('callsign','=', $callsign)->exists();
            if($callsign_exists)
            {
                $inputs = array(
                    'callsign' => $callsign,
                    'amount' => $attrs['val_price'],
                    'leixing' => $attrs['leixing'],
                    'keybeizhu' => $attrs['huo_dong'] . '_' . $attrs['keybeizhu'],
                    'cishu' => $attrs['cishu'],
                );

                $this->currencyService->createRedeemCode($inputs);
            }
            else
            {
                array_push($not_callsigns, $callsign);
            }
        }

        if(count($not_callsigns) > 0)
        {
            $request->session()->flash('status', '部分兑换码生成成功, 以下呼号不存在: '.implode(",", $not_callsigns));
            $request->session()->flash('alert-class', 'alert-danger');
        }
        else
        {
            $request->session()->flash('status', '成功生成兑换码!');
            $request->session()->flash('alert-class', 'alert-success');
        }
        return redirect()->back();
    }

    public function log()
    {
        return view('dashboard.admin.log', [
           'logs' => PilotSearchLog::orderByDesc('id')->paginate(20),
        ]);
    }
}
