@extends('clientui.frame')
@section('title')
    航司运营
@endsection
@section('submain')
    <!-- 框架内容 -->
    <div class="widget" ondragstart="return false;">
        @inject('fsvc', 'App\Services\FlightService')
        @if(empty($pinfo))
            <img alt="stop" src='{{asset('assets/images/client/cfr/STOP.png')}}'/>
            <b><center><font color="#FF3333">禁止访问! 未绑定航空人生账号<br /> 请登陆《飞行员系统》进入菜单 → 飞行员首页 → 航空人生 进行绑定</font></center></b>
        @else
        <ul class="tabs" >
            <li><a href="#tab1">机组|Crew</a></li>
            <li><a href="#tab2">任务|Task</a></li>
            <li><a href="#tab3">监控|Flight</a></li>
            <li><a href="#tab4">日志|Log</a></li>
            <li><a href="#tab5">计划|Plan</a></li>
            <li><a href="#tab6">说明|FAQ</a></li>
            @if($pinfo->lastname == '3804' || $pinfo->lastname == '8928' || $pinfo->huhao_user == "6862" || $pinfo->huhao_user == "3538" || $pinfo->huhao_user == "3131")
                <li><a href="#tab7">内测</a></li>
            @endif
        </ul>
        <!-- 分页开始 -->
        <div class="tab_container">
            <!-- 机组信息 -->
            <div id="tab1" class="tab_content">
                <div class="wrapper statsItems">
                    <div class="sItem ticketsStats">
                        <h2><a title="" class="value">{{ $pinfo->code }}<span>航空公司</span></a></h2>
                    </div>
                    <div class="sItem ticketsStats">
                        <h2><a title="" class="value">{{ $pinfo->lastname }}<span>机组呼号</span></a></h2>
                    </div>
                    <div class="sItem ticketsStats">
                        <h2><a title="" class="value">{{ $pinfo->hub }}<span>基地</span></a></h2>
                    </div>
                    <div class="sItem ticketsStats">
                        <h2><a title="" class="value" id="pilotID">{{ $pinfo->pilotid }}<span>登陆编号</span></a></h2>
                    </div>
                </div>
                <div class="line"></div>
                <div class="wInvoice">
                    <ul>
                        <li><h4 class="green">{{ $pinfo->totalhours }} h</h4><span>飞行小时</span></li>
                        <li><h4 class="blue">{{ $pinfo->totalpay }}</h4><span>飞行员工资</span></li>
                        <li><h4 class="red">{{ $pinfo->rank }}</h4><span>飞行等级</span></li>
                    </ul>
                    <ul>
                        <li><h4>{{ $pinfo->totalflights }}</h4><span>航班总数</span></li>
                        <li><h4>{{ $pinfo->flight_points }}</h4><span>航班点数</span></li>
                        <li><h4>{{ $pinfo->renwujifen }}</h4><span>任务积分</span></li>
                    </ul>
                    <br />
                </div>

                <div class="wrapper statsItems"><!-- 居中 -->
                    <b>飞 行 等 级 资 格 认 证 勋 章 | 准 驾 机 型 执 照</b>  <br />
                    <ul class="list-group">
                        @if($pinfo->flyingschool<=1)
                            <img src='{{ asset('assets/images/client/awards/F0.png') }}'/>
                        @else
                            <img src='{{ asset('assets/images/client/awards/F' .(intval($pinfo->flyingschool) - 1) . '.png') }}'/>
                        @endif
                    </ul>
                </div>

                <div class="line"></div>

                <h6 class="blue">
                    &nbsp; 1、 开始航班前请关闭 《跟随地形》《碰撞》 危险功能 ；<br />
                    &nbsp; 2、 预定航班 → 运行游戏 → 关闭危险功能 → 入停机位 → 冷舱开门；<br />
                    &nbsp; 3、 航前准备（加油配置） → 连接FS → 载入任务 → 输入 V 值 → 开始登机；<br />
                    &nbsp; 4、 下高开始 至 RA 2500 之前，输入 Vref ； RA 2500 以下将修改无效；<br />
                    &nbsp; 5、 接地到达 → 必须上传（等待提示完成）（出现异常请查看说明）；<br />
                </h6>
            </div>
            <!-- 机组信息结束 -->
            <!-- 航班任务 -->
            <div id="tab2" class="tab_content">
                <div class="statsRow">
                    <!-- 载入航班任务数据 -->
                    <table width="100%" class="sTable">
                        <thead>
                        <tr>
                            <td style="height:15px; width:60px; resize: none;">航班号</td>
                            <td style="height:15px; width:60px; resize: none;">出发机场</td>
                            <td style="height:15px; width:60px; resize: none;">到达机场</td>
                            <td style="height:15px; width:160px; resize: none;">预出时间</td>
                            <td style="height:15px; width:60px; resize: none;">预到时间</td>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td style="height:20px; width:60px; resize: none;" align="center"><a id="TxtMainFlightNo" class="webStatsLink">CFR0001</a></td>
                            <td style="height:20px; width:60px; resize: none;" align="center"><a id="TxtMainDepartureIcao" class="webStatsLink">ZBAA</a></td>
                            <td style="height:20px; width:60px; resize: none;" align="center"><a id="TxtMainArrivalIcao" class="webStatsLink">RKSI</a></td>
                            <td style="height:20px; width:160px; resize: none;" align="center"><a id="TxtMainSchDepTime" class="webStatsLink">00:00</a></td>
                            <td style="height:20px; width:60px; resize: none;" align="center"><a id="TxtMainSchArrivalTime" class="webStatsLink">01:05</a></td>
                        </tr>
                        </tbody>
                        <thead>
                        <tr>
                            <td style="height:15px; width:60px; resize: none;">巡航高度</td>
                            <td style="height:15px; width:60px; resize: none;">飞行阶段</td>
                            <td style="height:15px; width:40px; resize: none;">飞行时间</td>
                            <td style="height:15px; width:60px; resize: none;">计飞时长</td>
                            <td style="height:15px; width:180px; resize: none;">实出时间</td>
                            <!--<td style="height:20px; width:40px; resize: none;">提示</td>-->
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td style="height:20px; width:60px; resize: none;" align="center"><a id="TxtMainFlightLevel" class="webStatsLink">32100</a></td>
                            <td style="height:20px; width:60px; resize: none;" align="center"><a id="TxtMainFlightPhase" class="webStatsLink">----</a></td>
                            <td style="height:20px; width:60px; resize: none;" align="center"><a id="TxtMainFligtTime" class="webStatsLink">00:00</a></td>
                            <td style="height:20px; width:40px; resize: none;" align="center"><a id="TxtSchedulesFlightTime" class="webStatsLink">00:00</a></td>
                            <td style="height:20px; width:180px; resize: none;" align="center"><a id="TxtMainActDepTime" class="webStatsLink">00:00</a></td>
                            <!--<td style="height:20px; width:40px; resize: none;" align="center"><a id="" class=""></a></td>-->
                        </tr>
                        </tbody>
                        <table width="100%" class="sTable">
                            <thead>
                            <tr>
                                <td style="height:15px; width:50px; resize: none;">任务机型</td>
                                <td style="height:15px; width:150px; resize: none;">执飞机型</td>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td style="height:15px; width:50px; resize: none;" align="center"><a id="TxtMainAcAirframe" class="webStatsLink1">A320-100/200</a></td>
                                <td style="height:15px; width:50px; resize: none;" align="center"><a id="TxtFltDataAircraftTitle" class="webStatsLink1">Airbus A320</a></td>
                            </tr>
                            </tbody>
                        </table>
                        <textarea id='TxtMainRoute' style="height:40px; width:510px; resize: none;" placeholder="航路信息" onkeyup="value = value.replace(/[\u4e00-\u9fa5]/g, '')" readonly></textarea>
                        <div class="controlB">
                            <ul class="red">
                                <b>※ 请在登机前检查机场 加油 | 航班恢复有风险 | 接地前可关闭客户端 | 接地后必须上传 ※</b>
                                <div class="line"></div>
                                <li style="cursor: pointer;"><a id="BtnReconectToFS" onclick="MainWindowJSObject.vaConnectToSimulator()"><img src="{{asset('assets/images/client/icons/control/32/networking.png')}}" alt=""/><span>连接FS</span></a></li>
                                <li style="cursor: pointer;"><a id="BtnLoadBid" onclick="MainWindowJSObject.vaLoadTask()"><img src="{{asset('assets/images/client/icons/control/32/administrative-docs.png')}}" alt=""/><span>载入航班</span></a></li>
                                <li style="cursor: pointer;"><a id="BtnClearInformation" onclick="MainWindowJSObject.vaClearTask()"><img src="{{asset('assets/images/client/icons/control/32/basket.png')}}" alt=""/><span>清空数据</span></a></li>
                                <li style="cursor: pointer;"><a id="BtnStartFlightRecording" onclick="MainWindowJSObject.vaStartTask()"><img src="{{asset('assets/images/client/icons/control/32/world.png')}}" alt=""/><span>开始登机</span></a></li>
                                <li style="cursor: pointer;"><a id="BtnStopFlightRecording" onclick="MainWindowJSObject.vaEndTask()"><img src="{{asset('assets/images/client/icons/control/32/busy.png')}}" alt=""/><span>结束上传</span></a></li>
                                <ul class="red"><b>※ 登机提示机型错误 - 请到 VIP 会员专区 查看机型匹配状态 可进行二次登机 ※</b></ul>
                                <div class="line"></div>
                                <span class="oneThree"><input id="TxtMainV1" style="width:70px; resize: none;" type="text" maxlength="3" placeholder="V1" value="" /></span>
                                <span class="oneThree"><input id="TxtMainVR" style="width:70px; resize: none;" type="text" maxlength="3" placeholder="VR" value="" /></span>
                                <span class="oneThree"><input id="TxtMainV2" style="width:70px; resize: none;" type="text" maxlength="3" placeholder="V2" value="" /></span>
                                <span class="oneThree"><input id="TxtMainVref" style="width:70px; resize: none;" type="text" maxlength="3" placeholder="Vref" value="" /></span>
                                <div class="line"></div>
                                <textarea id='TxtMainComments' style="height:20px; width:500px; resize: none;" placeholder="* 航班备注/异常说明备注/问题反馈"></textarea>
                                <br />
                                <span id="LblFscConnected" style="text-align: center;">FS未连接</span>
                            </ul>
                        </div>
                    </table>
                </div>
            </div>
            <!-- 航班任务结束 -->
            <!-- 飞行监控 -->
            <div id="tab3" class="tab_content">
                <table width="100%" class="sTable">
                    <thead>
                    <tr>
                        <td style="height:15px; width:80px; resize: none;">经度</td>
                        <td style="height:15px; width:80px; resize: none;">纬度</td>
                        <td style="height:15px; width:70px; resize: none;">标准海拔高度</td>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td style="height:20px; width:80px; resize: none;" align="center"><a id="TxtFltDataLong" class="webStatsLink">36.533116665177</a></td>
                        <td style="height:20px; width:80px; resize: none;" align="center"><a id="TxtFltDataLat" class="webStatsLink">36.533116665177</a></td>
                        <td style="height:20px; width:70px; resize: none;" align="center"><a id="TxtFltDataAltitude" class="webStatsLink">7460</a></td>
                    </tr>
                    </tbody>
                </table>
                <table width="100%" class="sTable">
                    <thead>
                    <tr>
                        <td style="height:15px; width:30px; resize: none;">注册号</td>
                        <td style="height:15px; width:25px; resize: none;">地速</td>
                        <td style="height:15px; width:25px; resize: none;">表速</td>
                        <td style="height:15px; width:25px; resize: none;">空速</td>
                        <td style="height:15px; width:50px; resize: none;">开始燃油</td>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td style="height:20px; width:30px; resize: none;" align="center"><a id="TxtFltDataRegistration" class="webStatsLink1">B-2006</a></td>
                        <td style="height:20px; width:25px; resize: none;" align="center"><a id="TxtFltDataGspeed" class="webStatsLink">280</a></td>
                        <td style="height:20px; width:25px; resize: none;" align="center"><a id="TxtFltDataISpeed" class="webStatsLink">250</a></td>
                        <td style="height:20px; width:25px; resize: none;" align="center"><a id="TxtFltDataTspeed" class="webStatsLink">220</a></td>
                        <td style="height:20px; width:50px; resize: none;" align="center"><a id="TxtMainFuelStart" class="webStatsLink">20667</a></td>
                    </tr>
                    </tbody>
                    <table width="100%" class="sTable">
                        <thead>
                        <tr>
                            <td style="height:15px; width:65px; resize: none;">坡度</td>
                            <td style="height:15px; width:35px; resize: none;">垂直速度</td>
                            <td style="height:15px; width:10px; resize: none;">襟翼位</td>
                            <td style="height:15px; width:35px; resize: none;">剩余燃油</td>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td style="height:20px; width:65px; resize: none;" align="center"><a id="TxtFltDataHAngle" class="webStatsLink">level Flight</a></td>
                            <td style="height:20px; width:35px; resize: none;" align="center"><a id="TxtFltDataVangle" class="webStatsLink">0</a></td>
                            <td style="height:20px; width:10px; resize: none;" align="center"><a id="TxtFltDataFlaps" class="webStatsLink">3</a></td>
                            <td style="height:20px; width:35px; resize: none;" align="center"><a id="TxtFltDataFuelLeft" class="webStatsLink">205854</a></td>
                        </tr>
                        </tbody>
                    </table>
                    <br />
                    &nbsp; &nbsp; <b>※ 恢复航班有风险 | 退出关闭客户端前禁止回放 | 接地后必须上传报告</b><br /><br />
                    &nbsp; &nbsp; <b>※ 请在开始登机前加油，登机后禁止修改燃油 | 接地前有任何异常请及时关闭客户端</b><br /><br />
                    &nbsp; &nbsp; <b>※ 结束上传航班时，出现任何异常，请检查一下：</b><br />
                    &nbsp; &nbsp; &nbsp; 1、首页 - 实时航班动态 - 到达，目前未提交报告，否则禁止退出客户端；<br />
                    &nbsp; &nbsp; &nbsp; 2、请检查本地的飞行报告日志文件是否生成，否则禁止退出客户端；<br />  <br />
                    &nbsp; &nbsp; <b>※ 首页显示我的航班，已到达，目前未提交报告，处理方式如下：</b><br />
                    &nbsp; &nbsp; &nbsp; 1、飞行员提供本地飞行报告文件给公司管理 - 人工上传；<br />
                    &nbsp; &nbsp; &nbsp; 2、没有本地文件，规定时间内，联系公司管理，后台上传；<br /><br />
                    &nbsp; &nbsp; 本地的飞行报告日志文件路径：客户端目录\VirtualAirline\reports\年月日**.cfrpirepfinal 文件
                </table>
            </div> </div>
        <!-- 飞行监控结束 -->
        <!-- 飞行日志 -->
        <div id="tab4" class="tab_content">
            <div style="overflow: auto; height: 250px; border: 1px solid #666; margin-bottom: 20px; padding: 5px; padding-top: 0px; padding-bottom: 20px;">
                <table id="mytable" width="100%" border="0" cellspacing="0" cellpadding="0" class="ocean_table">
                    <thead>
                    <tr>
                        <th><center>公司航班号</center></th>
                        <th><center>出发机场</center></th>
                        <th><center>到达机场</center></th>
                        <th><center>提交时间</center></th>
                        <th><center>状态</center></th>
                    </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>

            </div>
            <input id="queryPirepsBtn" type="button" value="载入近30次航班报告" class="dredB logMeIn"> <br /><br /><br />
            <h6 class="red"> &nbsp;【 执飞任务时.禁止点击航班号查看飞行日志，避免异常发生 】</h6><br /><br />
        </div>
        <!-- 飞行日志结束 -->
        <!-- 签派开始 -->
        <div id="tab5" class="tab_content">
            <div class="formRow">
                <style type="text/css">
                    .wrapper {position: relative;}
                    #input {position: absolute;top: 0;left: 0;opacity: 0;z-index: -10;}
                </style>

                <textarea id="input">这是幕后黑手</textarea>
                <div>
                    <select id="hblx" name="select1" >
                        <option value="未选择航班类型">请选择航班运营类型</option>
                        <option value="客运 - 共享航班">客运 - 共享航班</option>
                        <option value="客运 - 非共享航班">客运 - 非共享航班</option>
                        <option value="货运 - 共享航班">货运 - 共享航班</option>
                        <option value="货运 - 非共享航班">货运 - 非共享航班</option>
                    </select>
                    所属：<input id="ssgs" type="text" class="input02" style="text-transform:uppercase;" value="{{ $pinfo->code }}- {{$pinfo->lastname}}"
                    readonly="readonly" />
                </div>
                <br /><br />
                <div>
                    <select id="cfjc" name="select2">
                        <option value="未选择出发机场">请选择出发机场</option>
                        @inject('vasvc', 'App\Services\VirtualAirlineService')
                        @foreach($vasvc->getAvailableHubs($pinfo->code) as $hub)
                            <option value="{{ $hub->icao }}">{{ $hub->country }} | {{ $hub->icao }} | {{ $hub->dengji }} 级</option>
                        @endforeach
                    </select>

                    <select id="ddjc" name="select3">
                        <option value="未选择到达机场">请选择到达机场</option>
                        @foreach($vasvc->getAvailableHubs($pinfo->code) as $hub)
                            <option value="{{ $hub->icao }}">{{ $hub->country }} | {{ $hub->icao }} | {{ $hub->dengji }} 级</option>
                        @endforeach
                    </select>
                </div>
                <br /><br /><br />
                <div>
                    <select id="hbjx" name="select4">
                        <option value="未选择航班执飞机型">请选择航班执飞机型</option>
                        @foreach($vasvc->getAvailableAircrafts($pinfo->code) as $ac)
                            <option value="{{$ac->id}}|{{$ac->name}}|{{$ac->registration}}|{{$ac->bieming}}"> {{$ac->id}} | {{$ac->name}} | {{$ac->registration}} | {{$ac->bieming}} - {{$ac->grade}} 级</option>
                        @endforeach
                    </select>

                    <select id="hbgd" name="select5">
                        <option value="未选择巡航高度">请选择巡航高度</option>
                        @foreach($vasvc->getAvailableAltitudes() as $lv)
                            <option value="{{ $lv->feet }}">{{ $lv->feet }}</option>
                        @endforeach
                    </select>
                </div>
                <br /><br /><br />

                <div>
                    预计出发时间： <input id="cfsj" type="text" class="timepicker" size="10" style="height:24px;"/>UTC<span class="f11"></span> &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
                    预计到达时间： <input id="ddsj" type="text" class="timepicker" size="10" style="height:24px;"/>UTC<span class="f11"></span>
                </div>
                <br />
                <div>
                    航路信息：<textarea id='hlxx' style="height:100px; width:500px; resize: none;" onkeyup="value = value.replace(/[\u4e00-\u9fa5]/g, '')"></textarea>
                </div>

                <br />
                <button onclick="copyText()">生成签派任务</button>

                <script type="text/javascript">
                    function copyText() {
                        var ssgs = "[ " + document.getElementById("ssgs").value + " ] 签派任务 COC v5.2\n";
                        var hblx = "航班类型：[ " + document.getElementById("hblx").value + " ]\n";
                        var cfjc = "出发机场：[ " + document.getElementById("cfjc").value + " ]\n";
                        var ddjc = "到达机场：[ " + document.getElementById("ddjc").value + " ]\n";
                        var hbjx = "执飞机型：[ " + document.getElementById("hbjx").value + " ]\n";
                        var hbgd = "巡航高度：[ " + document.getElementById("hbgd").value + " ]\n";
                        var cfsj = "预出时间：[ " + document.getElementById("cfsj").value + " ] UTC\n";
                        var ddsj = "预到时间：[ " + document.getElementById("ddsj").value + " ] UTC\n";
                        var hlxx = "航路：[ " + document.getElementById("hlxx").value + " ]\n";
                        var time = "[ " + new Date() + " ]\n";
                        let text = time + hblx + cfjc + ddjc + hbjx + hbgd + cfsj + ddsj + hlxx + ssgs;
                        var input = document.getElementById("input");
                        input.value = text; // 修改文本框的内容
                        input.select(); // 选中文本
                        document.execCommand("copy"); // 执行浏览器复制命令
                        alert("复制成功 发送给公司的管理员、签派员");
                    }
                </script>
            </div>
            &nbsp; &nbsp; &nbsp;* 生成签派任务后，发送给公司的管理员、签派员 <br />
            &nbsp; &nbsp; &nbsp;* 后续更新会直接生成航路信息，避免手动输入。 <br />
        </div>
        <!-- 签派结束 -->
        <!-- 说明 -->
        <div id="tab6" class="tab_content">
            &nbsp; &nbsp; &nbsp; &nbsp; <b> 必须下载，并仔细阅读最新的 【 航空人生 问题解答 运营规定 说明 .pdf 】；</b><br /> <br />
            &nbsp; &nbsp; &nbsp; <b> ※ 飞机报废：</b> <br />
            &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; 1、接地率 < - 600 , 过载 > 2.7 视为坠毁报废（不得恢复飞机）；<br />
            &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; 2、空中离地 8 个阶段导致报废碰撞坠毁（不得恢复飞机）<br />
            &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; 3、地面阶段 4 个阶段导致报废碰撞坠毁（可申请恢复飞机）<br />
            &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; 4、因恢复航班导致空中和地面任何阶段中，导致报废坠毁（不得恢复飞机）<br />  <br />

            &nbsp; &nbsp; &nbsp; <b> ※ 拒绝报告的判定条件：</b><br />
            &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; 1、飞行时长超限 - 实际飞行时长 > 计划签派飞行时长；<br />
            &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; 2、FOQA评价 > 航班机型限定标准值；<br />
            &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; 3、准点率、出发时间、到达时间、过载率、接地率这5项中存在零或空值；<br />
            &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; 4、运营评价 ＜ 200 分 ;  最终绩效 ＜ 1000 分；  准点率 ＜ 25 %；<br />
            &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; 5、坠毁或碰撞：起飞、离场、爬升、巡航、下降、进近、复飞、着陆阶段不能人工；<br />
            &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; 6、违规事件：飞行日志出现【△△△△△△】类型日志记录 倍速 位移等<br />
            &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; 7、异常事件：异常目的地机场、油量异常、燃油异常<br />
            &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; 8、特殊情况（按计划航路飞行，未出现盘旋，逆风等导致超时）可申请人工审核通过<br /> <br />
            &nbsp; &nbsp; &nbsp; &nbsp; 注释：运营评价项，超出公司规定的范围，仅扣分，不会被拒绝报告，总得分会导致拒绝<br /><br />

            &nbsp; &nbsp; &nbsp; 以上列出部分【 问题解答 运营规定 说明 .pdf 】内容，具体已‘帮助|支持’的PDF为准。<br /> <br />

            &nbsp; &nbsp; &nbsp; <b> ※ 补充说明：</b> <br />
            &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; 1、客舱语音音量调节， 请到《会员|VIP》专区中设置；<br />

            <br /><br />
        </div>


        <!-- 说明结束 -->
        <!-- 测试 -->
        <div id="tab7" class="tab_content">
            <div><input id="chkLandingLight" type="checkbox" disabled>&nbsp;&nbsp;着陆灯</div>
            <div><input id="chkStrobeLight" type="checkbox" disabled>&nbsp;&nbsp;频闪灯</div>
            <div><input id="chkNavLight" type="checkbox" disabled>&nbsp;&nbsp;导航灯</div>
            <div><input id="chkBeaconLight" type="checkbox" disabled>&nbsp;&nbsp;防撞灯(信标)</div>
            <div><input id="chkTaxiLight" type="checkbox" disabled>&nbsp;&nbsp;滑行灯</div>
            <div><input id="chkParkingBrake" type="checkbox" disabled>&nbsp;&nbsp;停机刹车</div>
            <div><input id="chkGear" type="checkbox" disabled>&nbsp;&nbsp;起落架</div>
            <div><input id="chkAutoPilot" type="checkbox" disabled>&nbsp;&nbsp;自动驾驶</div>
            <div><input id="chkDoorOpened" type="checkbox" disabled>&nbsp;&nbsp;开关门</div>
            <div><input id="chkEngineRunning" type="checkbox" disabled>&nbsp;&nbsp;引擎运行</div>
            <div><input id="chkSpoiler" type="checkbox" disabled>&nbsp;&nbsp;扰流板</div>
            <div><input id="chkReverse" type="checkbox" disabled>&nbsp;&nbsp;反推</div>
            <div><input id="chkFlapSet" type="checkbox" disabled>&nbsp;&nbsp;襟翼已设置</div>
            <div><a id="lblFlapPosition" class="webStatsLink">0</a>襟翼挡位</div>
            <div><a id="lblHDG2" class="webStatsLink">0</a>航向两秒变化率</div>
            <div><a id="lblLDO" class="webStatsLink">0</a>接地距离(旧)</div>
            <div><a id="lblLDN" class="webStatsLink">0</a>接地距离(新)</div>
            <div><a id="lblLDT" class="webStatsLink">0</a>接地用时</div>
        </div>
        <!-- 测试结束 -->
    </div>
    <!-- 分页开始结束 -->
    <div class="clear"></div><!-- 分割 -->
    @endif
@endsection
@section('script')
    @parent

    <script>
        $("#queryPirepsBtn").click(function(){
            $.ajax({
                url:"{{ route('api.public.va.pilot.pireps', $pinfo->pilotid) }}",
                type:"GET",
                dataType: 'json',
                async:true,
                success:function(result){
                    $('#mytable').find('tbody').empty();
                    for(var k in result) {
                        $('#mytable').find('tbody').append( "<tr><td><center><a href='http://va.hkonc.cn/index.php/pireps/view/"+ result[k].pirepid +"' target='_blank'>" + result[k].code + result[k].flightnum +"</td><td><center>" + result[k].depicao + "</td><td><center>" + result[k].arricao + "</td><td><center>" + result[k].submitdate + "</td><td><center>" + ((result[k].accepted == "1") ? "<font color='Blue'>通过</font>" : "<font color='red'>拒绝</font>") + "</td></tr>" );
                    }
                }
            });
        });
    </script>
@endsection