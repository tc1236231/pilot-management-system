@extends('clientui.frame')
@section('title')
    连飞中心
@endsection
@section('submain')
    <!-- 框架内容 -->
    <div class="widget chartWrapper" ondragstart="return false;">
        @inject('fsvc', 'App\Services\FlightService')
        @if($fsvc->getRestrictFlight() && Auth::user()->via==0)
            <b><h1 color="#FF3333" style="padding:100px;line-height:40px">禁止访问！您还未获得活动连飞资格，活动结束前，无法进入该频道！请前往飞行员系统进行考试</h1></b>
        @else
        <ul class="tabs">
            <li><a href="#tab1">飞行员 | Pilot</a></li>
            <li><a href="#tab2">计划 | Plan</a></li>
            <li><a href="#tab3">统计 | Statistics</a></li>
            <li><a href="#tab4">说明 | Explain</a></li>
        </ul>
        <!-- 分页开始 -->
        <div class="tab_container">
            <!-- 连线信息 -->
            <div id="tab1" class="tab_content">
                <!-- 获取飞行系统信息 -->
                <div class="genBalance">
                    <a class="amount" style="color:#FFCC00; height:45px; padding-top:14px; padding-bottom:7px;">
                        <span >Flight Time</span>
                        <span class="balanceAmount">{{ round(Auth::user()->onlinetime / 3600,2) }} h</span>
                    </a>
                    <a class="amChanges">
                        <strong class="sPositive" style="height:28px; padding-top:19px;">{{ round(Auth::user()->deltatime / 60,2) }} min</strong>
                    </a>
                    <a class="amount" style="color:#00CCFF; height:45px; padding-top:14px; padding-bottom:7px;">
                        <span>ATC Time</span>
                        <span class="balanceAmount">{{ round(Auth::user()->atctime / 3600,2) }} h</span>
                    </a>
                    <a class="amChanges" >
                        <strong class="sPositive" style="height:28px; padding-top:19px;">{{ round(Auth::user()->atcdeltatime / 60,2) }} min</strong>
                    </a>
                    <a href="{{ url('/') }}" target="_blank" class="amount" style="width:55px; height:43px; padding-top:14px; border-left-width:2px;">
                        <span>
                            @if(Auth::user()->banned)
                                <span style='color:red;'>已停飞</span>
                            @else()
                                <span style='color:Aqua;'>呼号</span>
                            @endif
                        </span>
                        <span class="balanceAmount" style="color:#80BFFF" >{{ Auth::user()->callsign }}</span>
                    </a>
                </div>
                <div class="line"></div>
                <!-- 获取飞连线信息 -->
                <div class="statsRow">
                    <div class="wrapper statsItems">
                        <div class="sItem ticketsStats"><h2><a class="value">{{ Auth::user()->platform }}<span>平台</span></a></h2></div>
                        <div class="sItem ticketsStats"><h2><a id="CompanyCode" class="value" style="padding-left: 16px; padding-right: 16px;">XXX<span>公司</span></a></h2></div>
                        <div class="sItem ticketsStats"><h2><a id="AircraftTypeCode" class="value" style="padding-left: 16px; padding-right: 16px;">XXXX<span>机型</span></a></h2></div>
                        <div class="sItem ticketsStats"><h2><a id="TransponderCode" class="value" style="padding-left: 16px; padding-right: 16px;">0000<span>应答机</span></a></h2></div>
                    </div>
                    <div class="wrapper statsItems">
                        <div class="sItem ticketsStats"><h2><a id="com1Label" class="value" style="padding-left: 16px; padding-right: 16px;">118.200<span>COM1</span></a></h2></div>
                        <div class="sItem visitsStats"><h2> <a id="com2Label" class="value" style="padding-left: 16px; padding-right: 16px;">127.900<span>COM2</span></a></h2></div>
                        <div class="sItem ticketsStats"><h2><a id="SimulatorStatus" class="value" style="padding-left: 15px; padding-right: 15px;">断开<span>模拟器</span></a></h2></div>
                        <div class="sItem ticketsStats"><h2><a id="SessionStatus" class="value" style="padding-left: 15px; padding-right: 15px;">断开<span>服务器</span></a></h2></div>
                    </div>
                </div>
                <div class="line"></div>
                <div class="formRow">
                    <div class="formRight">
                        <div class="floatL">
                            <select name="selectReq" id="selectServer" class="validate" >
                            @inject('fsvc', 'App\Services\FlightService')
                            @foreach($fsvc->getFlightServers() as $server)
                                    <option value='{{$server->ip}}'> {{$server->svname}} </option>
                            @endforeach
                            </select>  &nbsp;
                            @if(!Auth::user()->banned)
                            <input id="ConnectBtn" onclick="onConnectBtnClicked(false)" class="dredB" value="连线飞行" type="reset" />
                            @endif
                            <input id="DisconnectBtn" onclick="onDisconnectBtnClicked()" class="basic" value="断线飞行" type="reset" />&nbsp;
                            <!--
                            <input id="ConnectBtn" onclick="onConnectBtnClicked(true)" class="dredB" value="VIP连线" type="reset" />
                            -->
                        <!--
                        <input id="" onclick="shutdownVoice()" class="button dblueB" value="通信开关" type="reset" />
                         -->
                        </div>
                    </div><div class="clear"></div>
                </div><br />
                <b>连飞规定</b> <br />
                <b>&nbsp; &nbsp; 1、 连线后长时间不提交飞行计划、位置不变，客户端会自动断线! 不累积飞行时长! </b><br />
                &nbsp; &nbsp; 2、 禁止在跑道内直接“连线”；“连线”后, 禁止倍速飞行、瞬间移动位置,一经发现永久封号；<br />
                &nbsp; &nbsp; 3、 任何情况下选择连“连线”，必须提交飞行计划、离地后开启应答机，违规警告、封号处理；<br />
                &nbsp; &nbsp; 4、 ATC 管制范围下飞行，请听从管制指挥、特殊情况请与管制表明；<br />
                &nbsp; &nbsp; 5、 公用频率（默认:UNICOM | 各公司频率：见《新闻公告》→航空公司）；<br />
                &nbsp; &nbsp; 6、 语音测试，记得在最后加上自己的呼号，当听到提示音后在讲话！礼让信道避免占用；<br />
                &nbsp; &nbsp; 7、 机型识别：ERROR \ XXXXX, 请联系管理员，更新本地机型匹配数据；<br />
                <br /><br />
            </div>
            <!-- 连线信息结束 -->
            <!-- 飞行计划 -->
            <div id="tab2" class="tab_content">
                <div class="formRow">
                    <div>
                        <select id="FlightType" name="select2" >
                            <option value="">请选择飞行类型</option>
                            <option value="IFR">仪表飞行</option>
                            <option value="VFR">目视飞行</option>
                        </select>  &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp;
                        <input class="basic greyishB" onclick="MainWindowJSObject.loadVAFlightplan()" value="载入航司任务" type="reset" /> 先在航司运营载入航班
                    </div>
                    <br />
                    <div>
                        出发机场：<input id="DepICAO" maxlength="4" type="text" placeholder="ZBAA" class="input02" style="text-transform:uppercase;" pattern="[A-Z]{4}" value="" onkeyup="value = value.replace(/[\u4e00-\u9fa5]/g, '')"/>&nbsp; &nbsp; &nbsp;
                        到达机场：<input id="ArrICAO" maxlength="4" type="text" placeholder="ZSSS" class="input02" style="text-transform:uppercase;" pattern="[A-Z]{4}" value="" onkeyup="value = value.replace(/[\u4e00-\u9fa5]/g, '')"/>
                    </div>
                    <br />
                    <div>
                        备降机场：<input id="AlternativeICAO" type="text" maxlength="4" placeholder="ZAAA" class="input02" style="text-transform:uppercase;" pattern="[A-Z]{4}" value="" onkeyup="value = value.replace(/[\u4e00-\u9fa5]/g, '')" />&nbsp; &nbsp; &nbsp;
                        巡航高度：<input id="Altitude" type="text" maxlength="5" placeholder="32100" value="" onkeyup="value = value.replace(/[\u4e00-\u9fa5]/g, '')"/>
                    </div>
                    <br />
                    <div>
                        航路信息：<textarea id='routeTextBox' style="height:90px; width:500px; resize: none;" onkeyup="value = value.replace(/[\u4e00-\u9fa5]/g, '')"></textarea>
                    </div>
                    <br />
                    <div>
                        航班备注：<textarea id='noteTextBox' placeholder="自定义" style="height:40px; width:500px; resize: none;" onkeyup="value = value.replace(/[\u4e00-\u9fa5]/g, '')"></textarea>
                    </div>
                    <br />
                    <div>
                        <input id="plannedVA" type="checkbox" disabled>我是VA航班
                        &nbsp; &nbsp; &nbsp;预发时间 UTC <input id="plannedDepTime" type="text" class="timepicker" size="10" style="height:18px;"/><span class="f10"></span>
                        &nbsp; &nbsp; &nbsp;预到时间 UTC <input id="plannedArrTime" type="text" class="timepicker" size="10" style="height:18px;"/><span class="f10"></span>
                    </div>
                    <br />
                    <div>
                        &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
                        <input onclick="onLoadFlightplanBtnClicked()" class="basic greyishB" value="载入上次计划" type="reset" />   &nbsp; &nbsp; &nbsp;
                        <input onclick="onFileFlightplanBtnClicked()" class="brownB" value="提交飞行计划" type="reset" />
                    </div>
                </div><br />
            </div>
            <!--飞行计划结束 -->
            <!-- 飞行统计 -->
            <div id="tab3" class="tab_content" onmousedown="return false">
                <div class="wrapper statsItems"><!-- 居中 -->
                    <div class="panel-heading"><h5>连线飞行统计</h5> </div><br />
                    <table width="100%" border="1">
                        @if(Auth::user()->timeStats)
                            <tr>
                                <td align="center">1月</td>
                                <td>{{ print_flight_time(Auth::user()->timeStats->m1) }}</td>
                                <td align="center">2月</td>
                                <td>{{ print_flight_time(Auth::user()->timeStats->m2) }}</td>
                                <td align="center">3月</td>
                                <td>{{ print_flight_time(Auth::user()->timeStats->m3) }}</td>
                                <td align="center">4月</td>
                                <td>{{ print_flight_time(Auth::user()->timeStats->m4) }}</td>
                                <td align="center">5月</td>
                                <td>{{ print_flight_time(Auth::user()->timeStats->m5) }}</td>
                                <td align="center">6月</td>
                                <td>{{ print_flight_time(Auth::user()->timeStats->m6) }}</td>
                            </tr>
                            <tr>
                                <td align="center">7月</td>
                                <td>{{ print_flight_time(Auth::user()->timeStats->m7) }}</td>
                                <td align="center">8月</td>
                                <td>{{ print_flight_time(Auth::user()->timeStats->m8) }}</td>
                                <td align="center">9月</td>
                                <td>{{ print_flight_time(Auth::user()->timeStats->m9) }}</td>
                                <td align="center">10月</td>
                                <td>{{ print_flight_time(Auth::user()->timeStats->m10) }}</td>
                                <td align="center">11月</td>
                                <td>{{ print_flight_time(Auth::user()->timeStats->m11) }}</td>
                                <td align="center">12月</td>
                                <td>{{ print_flight_time(Auth::user()->timeStats->m12) }}</td>
                            </tr>
                        @else
                            <td>暂无时长数据</td>
                        @endif
                    </table>
                </div> <br />
                <b>注意事项</b> <br />
                <b>&nbsp; &nbsp; ※ 连线后长时间不提交飞行计划、位置不移动，客户端会自动断线! 不累积飞行时长! ※</b><br />
                <b>&nbsp; &nbsp; ※ 登陆飞行员系统 - 连线飞行小时可兑换飞行币 ※</b><br />
            </div>
            <!-- 飞行统计结束 -->
            <!-- 分页2 -->
            <div id="tab4" class="tab_content">
                <h5>连飞说明</h5>
                &nbsp; 1、 进入管制雷达范围内，请主动联系管制人员； <br />
                &nbsp; 2、 COM1 和 COM 2 与机载通讯面板联动操作；通过机载通讯面板进行收听、送话； <br />
                &nbsp; 3、 COM1 主通讯开启（收听、送话）； COM2 辅通讯开启（收听 ATIS 信息）；<br />
                &nbsp; 4、 可通过全部静音键或关闭机载，拒绝收听；<br />
                &nbsp; 5、 断开语音、或被管制踢出语音后，需要重新连线，加入语音通信； <br />
                &nbsp; 6、 COM 1 2 显示（UNICOM） → 说明你当前处于公共频率守候（切换频道提示音）；<br />
                &nbsp; 7、 已设置COM 1 2 频率, COM 1 2 全部显示（UNICOM）；<br />
                &nbsp; &nbsp; &nbsp; &nbsp;  → 说明调频失败,你调的频率错误或无管制；<br />
                &nbsp; &nbsp; &nbsp;  &nbsp; → 建议更换机模重新加载测试；<br />
                &nbsp; 8、送话问题 → 先测试语音，如正常听到自己声音!检查飞机通讯面板麦克开关<br />
                &nbsp; 9、如果 ATC \ COM1 \ COM2 同时连接语音, 则会出现送话有送话失败的问题，禁止同时连线；<br />
                &nbsp; 10、应答机按钮（红-关闭 黄-开启 二次雷达 绿-开启）；<br />
                &nbsp; 11、机组通讯窗口功能<br />
                &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;  → 全体机组：输入内容-发送；<br />
                &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;  → 私聊机组：机组呼号（CCA8928）+空格+内容-发送；<br />
                &nbsp; &nbsp; &nbsp; &nbsp; 管制通信窗口功能<br />
                &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;  → 全部管制：输入内容-发送；<br />
                &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;  → 私聊管制：席位名称（ZBAA_APP）+空格+内容-发送；<br />
                &nbsp; &nbsp; &nbsp; &nbsp; 终端通信窗口功能<br />
                &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;  → ATIS查询：输入ATIS频率（118.200）-发送；<br />
                &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;  → 天气查询：输入机场四字码（输入 ZBAA）-发送；<br />
                <br />
            </div>
            <!-- 分页3结束 -->
        </div>
        <!-- 分页开始结束 -->
        <div class="clear"></div><!-- 分割 -->
        @endif
    </div>
    <!-- 框架内容结束 -->
    <div class="clear"></div>
@endsection
@section('script')
    @parent

    <script language="javascript">
        function testInput(event) {
            var value = String.fromCharCode(event.which);
            var pattern = new RegExp(/[a-zA-Z]/i);
            return pattern.test(value);
        }

        $('#DepICAO').bind('keypress', testInput);
        $('#ArrICAO').bind('keypress', testInput);
        $('#AlternativeICAO').bind('keypress', testInput);
    </script>
    <script type="text/javascript">
        function showLocale(objD)
        {
            var str,colorhead,colorfoot;
            var hh = objD.getUTCHours();
            if(hh<10) hh = '0' + hh;
            var mm = objD.getUTCMinutes();
            if(mm<10) mm = '0' + mm;
            var ss = objD.getUTCSeconds();
            if(ss<10) ss = '0' + ss;
            str = hh + ":" + mm + ":" + ss + " " ;
            //alert(str);
            return str;
        }
        function tick()
        {
            var today;
            today = new Date();
            document.getElementById("ntime").innerHTML = showLocale(today);
            window.setTimeout("tick()", 1000);
        }
        tick();
    </script>
@endsection
