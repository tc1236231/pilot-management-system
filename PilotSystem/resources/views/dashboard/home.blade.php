@extends('dashboard.layout')
@section('title')
    基本信息
@endsection
@section('page-name')
    基本信息
@endsection
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <table class="table table-bordered table-dark">
                    <tr>
                        <td>所属平台：{{ $user->co }} &nbsp;&nbsp;&nbsp; 飞行员呼号：{{ $user->callsign }} &nbsp;&nbsp;&nbsp;
                            呼号类型：{{ PilotLevel::label($user->level) }}
                        </td>
                    </tr>
                    <tr>
                        <td>呼号状态：{{ $user->namelog  }}
                            <?php {
                                $namelog = $user->namelog;
                                if($namelog=='自退禁止加群')echo "&nbsp;&nbsp; - 因为自行退过官方群、连飞群或飞院群，该将无法加入任何群";
                                if($namelog=='邮箱激活呼号')echo "&nbsp;&nbsp; - 已通过注册邮箱激活了该呼号";
                                if($namelog=='呼号未激活')echo "&nbsp;&nbsp; - 请通过注册邮件进行激活或补充【个人信息】后，申请人工激活";
                            }?>
                        </td>
                    </tr>
                    <tr>
                        <td>连飞资格：{{ \App\Models\Enums\PilotFlightPermission::label($user->via) }}
                            @if($user->via == 0)
                                <a href='http://bbs.chinaflier.com/plugin.php?id=exam' target='_black' class='btn-sm btn-primary' role='button'>进入考试系统</a>
                            @endif
                        </td>
                    <tr>
                        <td>即时通讯：{{ $user->icq }} &nbsp;&nbsp;&nbsp; 呼号注册邮箱：{{ $user->email }}</td>
                    </tr>

                    <tr>
                        <td>注册日期：{{ $user->registertime }} &nbsp;&nbsp;&nbsp; 登陆日期：{{ $user->logintime }}  &nbsp;&nbsp;&nbsp; 数据更新：{{ $user->uptime }} </td>
                    </tr>

                    <tr>
                        <td>特殊说明：{{ $user->txt }} </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
    <br />
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <table width="100%" class="table table-bordered table-dark" border="1">
                    <tr >
                        <td>累计连飞时长：</td>
                        <td>{{ print_flight_time($user->onlinetime) }} (已兑换时长: {{ print_flight_time($user->xiaohaotime) }})</td>
                        <td>累计管制时长：</td>
                        <td>{{ print_flight_time($user->atctime) }}</td>
                    </tr>
                    <tr>
                        <td>连飞上线日期：</td>
                        <td>{{ $user->pologintime }}</td>
                        <td>连飞下线日期：</td>
                        <td>{{ $user->poendtime }}</td>
                    </tr>
                    <tr>
                        <td>管制上线日期：</td>
                        <td>{{ $user->atclogintime }}</td>
                        <td>管制下线日期：</td>
                        <td>{{ $user->atcendtime }}</td>
                    </tr>
                    <tr>
                        <td>最近飞行持续：</td>
                        <td>{{ print_flight_time($user->deltatime) }}</td>
                        <td>最近管制持续：</td>
                        <td>{{ print_flight_time($user->atcdeltatime) }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
    <br />
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <table width="100%" class="table table-bordered table-dark" border="1">
                    @if($timeStats)
                    <tr>
                        <td align="center">1月</td>
                        <td>{{ print_flight_time($timeStats->m1) }}</td>
                        <td align="center">2月</td>
                        <td>{{ print_flight_time($timeStats->m2) }}</td>
                        <td align="center">3月</td>
                        <td>{{ print_flight_time($timeStats->m3) }}</td>
                        <td align="center">4月</td>
                        <td>{{ print_flight_time($timeStats->m4) }}</td>
                        <td align="center">5月</td>
                        <td>{{ print_flight_time($timeStats->m5) }}</td>
                        <td align="center">6月</td>
                        <td>{{ print_flight_time($timeStats->m6) }}</td>
                    </tr>
                    <tr>
                        <td align="center">7月</td>
                        <td>{{ print_flight_time($timeStats->m7) }}</td>
                        <td align="center">8月</td>
                        <td>{{ print_flight_time($timeStats->m8) }}</td>
                        <td align="center">9月</td>
                        <td>{{ print_flight_time($timeStats->m9) }}</td>
                        <td align="center">10月</td>
                        <td>{{ print_flight_time($timeStats->m10) }}</td>
                        <td align="center">11月</td>
                        <td>{{ print_flight_time($timeStats->m11) }}</td>
                        <td align="center">12月</td>
                        <td>{{ print_flight_time($timeStats->m12) }}</td>
                    </tr>
                    @else
                        <td>暂无时长数据</td>
                    @endif
                </table>
            </div>
        </div>
    </div>
@endsection