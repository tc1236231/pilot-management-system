<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Requests\BindPlatformRequest;
use App\Http\Requests\BindVARequest;
use App\Http\Requests\RedeemFlightHoursRequest;
use App\Http\Requests\UnbindPlatformRequest;
use App\Http\Requests\UpdateProfileRequest;
use App\Http\Requests\UseRedeemCodeRequest;
use App\Models\PilotPlatform;
use App\Models\Platform;
use App\Http\Controllers\Controller;
use App\Services\CurrencyService;
use App\Services\PlatformService;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    private $platformService;
    private $currencyService;

    public function __construct(PlatformService $platformService, CurrencyService $currencyService)
    {
        $this->platformService = $platformService;
        $this->currencyService = $currencyService;
    }

    //
    public function index()
    {
        $user = Auth::user();
        return view('dashboard.home', [
            'user' => $user,
            'timeStats' => $user->timeStats
        ]);
    }

    //
    public function bindPlatformShow()
    {
        $user = Auth::user();
        return view('dashboard.platformbind', [
            'user' => $user,
            'platforms' => Platform::where('shouquan','=','1')->get(),
            'user_platforms' => $user->platforms,
        ]);
    }

    //
    public function bindPlatform(BindPlatformRequest $request)
    {
        $inputs = $request->all();
        list($validated, $bind_info) = $this->platformService->validateUsernamePassword($inputs);

        if(!$validated)
        {
            return redirect()->back();
        }

        $bind_info['callsign'] = $request->user()->callsign;
        $pilot_platform = new PilotPlatform($bind_info);
        $pilot_platform->save();

        $request->session()->flash('status', '绑定成功!');
        return redirect()->back();
    }

    //
    public function unbindPlatform(UnbindPlatformRequest $request)
    {
        $platform = $request->all()['platform'];
        $pilot_platform = PilotPlatform::where('bbscode','=',$platform)
            ->where('callsign','=', $request->user()->callsign)
            ->get()->first();
        $pilot_platform->delete();

        return response()->json('解绑成功');
    }

    public function profile()
    {
        $user = Auth::user();
        $locked = !empty($user->realname) && !empty($user->phone) || !empty($user->dizhi);
        return view('dashboard.profile', [
            'user' => $user,
            'locked' => $locked,
            'logs' => $user->logs()->orderByDesc('id')->paginate(15),
        ]);
    }

    public function updateProfile(UpdateProfileRequest $request)
    {
        $user = Auth::user();
        $locked = !empty($user->realname) && !empty($user->phone) || !empty($user->dizhi);
        if($locked)
        {
            $request->session()->flash('status', '无法直接二次修改个人信息,请申请人工变更');
            $request->session()->flash('alert-class', 'alert-danger');
            return redirect()->back();
        }
        $attrs = $request->all();
        $user->update($attrs);

        $request->session()->flash('status', '修改成功!');
        $request->session()->flash('alert-class', 'alert-success');
        return redirect()->back();
    }

    public function redeem()
    {
        $user = Auth::user();
        return view('dashboard.redeem', [
            'user' => $user,
            'platforms' => $user->platforms()->with('platform')->whereHas('platform',function ($query) {
                $query->where('shouquan', '=', 1);
            })->get()->pluck('platform'),
            'coupons' => $user->redeemCodes->where('yesno','=','1')
                ->where('amount','>','0'),
            'all_coupons' => $user->redeemCodes()->orderByDesc('id')->paginate(15),
        ]);
    }

    public function redeemFlightHours(RedeemFlightHoursRequest $request)
    {
        $qty = $request->all()['quantity'];
        $user = Auth::user();
        $onlinetime=intval($user->onlinetime);
        $xiaohaotime=intval($user->xiaohaotime);
        $avaliableTime = $onlinetime - $xiaohaotime;
        $requiredTime = $qty * 5 * 3600;
        if($requiredTime > $avaliableTime)
        {
            $request->session()->flash('status', '飞行小时数不足以兑换');
            $request->session()->flash('alert-class', 'alert-danger');
            return redirect()->back();
        }

        $user->xiaohaotime += $requiredTime;
        $user->saveOrFail();

        $inputs = array(
            'callsign' => $request->user()->callsign,
            'amount' => $qty,
            'leixing' => 1,
            'keybeizhu' => '飞行小时兑换_'. ($qty * 5) . "小时",
            'cishu' => 0,
        );
        $this->currencyService->createRedeemCode($inputs);

        $request->session()->flash('status', '成功生成兑换码!');
        $request->session()->flash('alert-class', 'alert-success');
        return redirect()->back();
    }

    public function useRedeemCode(UseRedeemCodeRequest $request)
    {
        $attrs = $request->all();
        $result = $this->currencyService->useRedeemCode($attrs);

        $request->session()->flash('status', '兑换成功!');
        $request->session()->flash('alert-class', 'alert-success');
        return redirect()->back();
    }

    public function transfer()
    {
        $user = Auth::user();
        return view('dashboard.transfer', [
            'user' => $user
        ]);
    }

    public function va()
    {
        $user = Auth::user();

        $va = $this->platformService->getVirtualAirlineInfo($user->callsign);

        return view('dashboard.va', [
            'user' => $user,
            'va' => $va,
        ]);
    }

    public function bindva(BindVARequest $request)
    {
        $attrs = $request->all();
        $callsign = $request->user()->callsign;
        $duplicate = \DB::table('pilotsdatava')->where('callsign','=',$callsign)
            ->exists();
        if($duplicate)
        {
            $request->session()->flash('status', '已经绑定');
            $request->session()->flash('alert-class', 'alert-danger');
            return redirect()->back();
        }

        $validated = $this->platformService->validateVirtualAirline($attrs);

        if(!$validated)
        {
            return redirect()->back();
        }

        \DB::table('pilotsdatava')->insert(array(
            'callsign' => $callsign,
        ));

        $request->session()->flash('status', '绑定成功!');
        $request->session()->flash('alert-class', 'alert-success');
        return redirect()->back();
    }


}
