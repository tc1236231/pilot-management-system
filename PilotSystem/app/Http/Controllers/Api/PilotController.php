<?php

namespace App\Http\Controllers\Api;

use App\Models\Enums\PilotLevel;
use App\Models\Pilot;
use http\Env\Response;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Input;

class PilotController extends Controller
{
    private function hideStar($str) { //QQ、邮箱 中间字符串以*隐藏
        if (strpos($str, '@')) {
            $pilotsemail = explode("@", $str);
            $prevfix = (strlen($pilotsemail[0]) < 4) ? "" : substr($str, 0, 3); //邮箱前缀
            $count = 0;
            $str = preg_replace('/([\d\w+_-]{0,100})@/', '***@', $str, -1, $count);
            $rs = $prevfix . $str;
        } else {
            $icq = '/(1[3458]{1}[0-9])[0-9]{4}([0-9]{4})/i';
            if (preg_match($icq, $str)) {
                $rs = preg_replace($icq, '$1****$2', $str); // substr_replace($name,'****',3,4);
            } else {
                $num_str = explode(":", $str);
                if(count($num_str) <= 1 || strlen($num_str[1]) < 5)
                {
                    $rs =  str_repeat("*", strlen($str));
                }
                else
                {
                    $rs =  $num_str[0] . substr($num_str[1],0,1) . str_repeat("*", strlen($num_str[1])-5) . substr($num_str[1], -4);
                }
            }
        }
        return $rs;
    }

    public function verifyCallsignPassword()
    {
        $callsign = Input::get('callsign','');
        $password = Input::get('password','');
        if(strlen($callsign) != 4 || !is_numeric($callsign))
            return response()->json(['status' => 'error', 'message' => '呼号格式错误']);

        $pilot = Pilot::where('callsign', '=', $callsign)->first();
        if(!$pilot)
            return response()->json(['status' => 'error', 'message' => '呼号不存在']);

        if (!Hash::check($password, $pilot->password))
            return response()->json(['status' => 'error', 'message' => '呼号密码错误']);

        if ($pilot->level == PilotLevel::BANNED)
            return response()->json(['status' => 'error', 'message' => '呼号停飞']);

        return response()->json(['status' => 'success', 'message' => '', 'pilot' => $pilot]);
    }

    public function queryPublicPilotStatus()
    {
        $callsign = Input::get('callsign','');
        $type = Input::get('type','callsign');
        if($type == "callsign")
        {
            if(strlen($callsign) != 4 || !is_numeric($callsign))
                return response()->json(['message' => '呼号格式错误'], 422);

            $pilot = Pilot::where('callsign', '=', $callsign)->first();
            if(!$pilot)
                return response()->json(['message' => '该呼号不存在'], 422);
        }
        else if($type == "icq")
        {
            $pilot = Pilot::where('icq', 'LIKE', '%'. $callsign . '%')->first();
            if(!$pilot)
                return response()->json(['message' => '该呼号不存在'], 422);
        }
        else
        {
            return response()->json(['message' => '无输入'], 422);
        }

        if($pilot->level >= PilotLevel::PLATFORM_ADMIN)
            return response()->json(['message' => '你无权查看该呼号信息'], 401);

        $message = $pilot->callsign . "<br />所属平台：".$pilot->co." &nbsp;&nbsp; 呼号类型：".PilotLevel::label($pilot->level)."<br />
          ".$this->hideStar($pilot->icq)."   激活邮箱：".$this->hideStar($pilot->email)."<br />
          累计连飞：".round((($pilot->onlinetime)/3600),2)."小时 &nbsp; 累计管制：".round((($pilot->atctime)/3600),2)."小时<br />
          <br />
          呼号状态：[ ".$pilot->namelog." ] ";

        $icq = $pilot->icq;
        $namelog = $pilot->namelog;
        if($namelog=="邮箱激活呼号") $message .= '该呼号正常 - 如使用'.$this->hideStar($icq).'加群,许可通过.  <br />拒绝 - →<fonts color="Fuchsia">因QQ号不符,请使用'.$this->hideStar($icq).'加群</fonts>←<br />拒绝 - →<fonts color="Fuchsia">因Q龄过低,必须绑定姓名</fonts>←';
        if($namelog=="人工激活呼号") $message .= '该呼号正常 - 如使用'.$this->hideStar($icq).'加群,许可通过.  <br />拒绝 - →<fonts color="Fuchsia">因QQ号不符,请使用'.$this->hideStar($icq).'加群</fonts>←<br />拒绝 - →<fonts color="Fuchsia">因Q龄过低,必须绑定姓名</fonts>←';
        if($namelog=="一次解封激活") $message .= '该呼号禁飞过1次 - 如使用'.$this->hideStar($icq).'加群,许可通过. <br />拒绝 - →<fonts color="Fuchsia">因QQ号不符,请使用'.$this->hideStar($icq).'加群</fonts>←<br />拒绝 - →<fonts color="Fuchsia">因Q龄过低,必须绑定姓名</fonts>←';
        if($namelog=="二次解封激活") $message .= '该呼号禁飞过2次 - 如使用'.$this->hideStar($icq).'加群,许可通过. <br />拒绝 - →<fonts color="Fuchsia">因QQ号不符,请使用'.$this->hideStar($icq).'加群</fonts>←<br />拒绝 - →<fonts color="Fuchsia">因Q龄过低,必须绑定姓名</fonts>←';
        if($namelog=="四次解封激活") $message .= '该呼号禁飞过4次 - 如使用'.$this->hideStar($icq).'加群,许可通过. <br />拒绝 - →<fonts color="Fuchsia">因QQ号不符,请使用'.$this->hideStar($icq).'加群</fonts>←<br />拒绝 - →<fonts color="Fuchsia">因Q龄过低,必须绑定姓名</fonts>←';
        if($namelog=="广告解封呼号") $message .= '广告解封呼号 - 如使用'.$this->hideStar($icq).'加群,许可通过. <br />拒绝 - →<fonts color="Fuchsia">因QQ号不符,请使用'.$this->hideStar($icq).'加群</fonts>← <br />拒绝 - →<fonts color="Fuchsia">因Q龄过低,必须绑定姓名</font>←';
        if($namelog=="自退禁止加群") $message .= '→<fonts color="Fuchsia">因主动退过群-禁止再次加入群</fonts>← <br />拒绝 - →<fonts color="Fuchsia">因Q龄过低,必须绑定姓名</fonts>←';
        if($namelog=="广告禁止加群") $message .= '→<fonts color="Fuchsia">因群内广告过-禁止加入任何群</fonts>← <br />拒绝 - →<fonts color="Fuchsia">因Q龄过低,必须绑定姓名</fonts>←';
        if($namelog=="论坛广告禁言") $message .= '→<fonts color="Fuchsia">因论坛违规过-禁止加入任何群</fonts>← <br />拒绝 - →<fontss color="Fuchsia">因Q龄过低,必须绑定姓名</fontss>←';
        if($namelog=="呼号未激活")   $message .= '→<fonts color="Fuchsia">请使用激活邮箱地址激活-禁止加入任何群</fonts>← <br />拒绝 - →<fonts color="Fuchsia">因Q龄过低,必须绑定姓名</fonts>←';
        if($namelog=="呼号信息不全") $message .= '→<fonts color="Fuchsia">请提供现有信息与管理员联系,补充呼号信息-目前禁止加入任何群</fonts>← <br />拒绝 - →<fonts color="Fuchsia">因Q龄过低,必须绑定姓名</fonts>←';

        return response()->json(['message' => $message]);
    }
}
