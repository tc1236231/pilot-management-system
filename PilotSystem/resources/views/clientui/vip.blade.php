@extends('clientui.frame')
@section('title')
    会员
@endsection
@section('submain')
    <!-- 框架内容 -->
    <div class="widget" ondragstart="return false;">
        <!-- 获取VIP飞行系统信息 -->
        <div class="genBalance">
            <a class="amount" style="color:#FFCC00; width:125px; height:45px; padding-top:14px; padding-bottom:7px;">
                <span >开始时间</span>
                <span class="balanceAmount">0000-00-00</span>
            </a>

            <a class="amount" style="color:#00CCFF; width:125px; height:45px; padding-top:14px; padding-bottom:7px;">
                <span>到期时间</span>
                <span>
                    <span class='balanceAmount'>暂无</span>
                </span>
            </a>

            <a target="_blank" class="amount" style="width:82px; height:43px; padding-top:14px; border-left-width:2px;">
                <span style='color:Lime;'>欢迎</span>
                <span class="balanceAmount" style="color:#FFCC00" >{{ Auth::user()->callsign }}</span>
            </a>

            <a target="_blank" class="amount" style="width:82px; height:43px; padding-top:14px; border-left-width:2px;">
                <span style='color:#FFCC00;'>连飞资格</span>

                <span class="balanceAmount">
                @if(!Auth::user()->FlightPermission)
                    <span class='balanceAmount' style='color:red;'>未获得</span>
                @else
                    <span class='balanceAmount' style='color:Lime;'>已获得</span>
                @endif
                </span>
            </a>
        </div>
        <div class="line"></div><!-- 分割 -->
        <!-- 获取VIP飞行系统信息结束 -->
        <ul class="tabs" >
            <li><a href="#tab1">航路查询 | Route </a></li>
            <li><a href="#tab2">功能中心 | Functional</a></li>
            <li><a href="#tab3">客舱服务 | Cabin</a></li>
            <li><a href="#tab4">机型匹配 | Matching</a></li>
        </ul>
        <!-- 分页开始 -->
        <div class="tab_container">
            <!-- 航路查询 -->
            <div id="tab1" class="tab_content">

                <!-- 获取航路信息 -->
                <div>

                    <br />
                    <div>
                        出发机场:<input id="depICAOInput" maxlength="4" type="text" placeholder="ZBAA" class="input02" style="text-transform:uppercase; width:80px; height:20px;" pattern="[A-Z]{4}" value="" onkeyup="value = value.replace(/[\u4e00-\u9fa5]/g, '')"/> &nbsp;
                        到达机场:<input id="arrICAOInput" maxlength="4" type="text" placeholder="ZBAA" class="input02" style="text-transform:uppercase; width:80px; height:20px;" pattern="[A-Z]{4}" value="" onkeyup="value = value.replace(/[\u4e00-\u9fa5]/g, '')"/>&nbsp;
                        <input id="flightDistance" maxlength="4" type="text" placeholder="飞行距离" class="input02" style="text-transform:uppercase; width:100px; height:20px; margin-left:10px;" pattern="[0-9]{10}" value="" onkeyup="value = value.replace(/[\u4e00-\u9fa5]/g, '')" disabled="disabled" /> 海里(NM) &nbsp;
                    </div>

                    <br />

                    <div class="selector" style="width:250px; padding-left:0px;">
                        <select id="SIDSelect" style="width:250px; padding-left:0px;">
                            <option style="width:250px;" value="">请选择离场程序</option>
                        </select>
                    </div>

                    <div class="selector" style="width:250px; padding-left:0px;margin-left: 15px;">
                        <select id="STARSelect" style="width:250px; padding-left:0px;">
                            <option style="width:250px;" value="">请选择进场程序</option>
                        </select>
                    </div>

                    <br />
                    <br />

                    <div class="selector" style="width:110px; padding-left:0px;">
                        <select id="CycleSelect" style="width:110px; padding-left:0px;">
                            <option style="width:110px;" value="1807">AIRAC1807</option>
                            <option style="width:110px;" value="1806">AIRAC1806</option>
                        </select>
                    </div>

                    <button style="margin-left:50px" id="calculateBtn">计算航路</button>

                    <br /><br />
                    <div>
                        <textarea id='routeInfo' style="height:130px; width:500px; resize: none;" placeholder="航路信息"></textarea>
                    </div>
                    <br />
                    <div style="text-align:center;">
                        <button id="">导入航司签派</button><button id="">导入飞行计划</button><button id="">另存为导航文件</button>
                    </div><br />
                    &nbsp; &nbsp; *  目前功能均可免费使用！<br />
                </div>
                <!-- 获取航路信息结束 -->
            </div>
            <!-- 航路查询结束 -->
            <!-- 功能 -->
            <div id="tab2" class="tab_content">
                <div class="formRow">
                    <input id="TransponderStatusCheckBox" onclick="MainWindowJSObject.switchTransponderMonitor()" type="checkbox">【启用机载应答机联动】（需安装 FSUIPC | XPUIPC）<br />
                    <h5 style="text-align: center; margin-top: 15px;">机载应答机联动功能说明</h5>
                    <p>目前支持机型: PMDG 737系列\747系列\777系列，XPLANE部分机型</p>
                    <p>PMDG机型 需要手动更改对应机型PMDG目录的 XXXXXX_Options.ini 文件以保证数据链畅通, 具体添加文本为:</p>
                    <p>[SDK] <br /> EnableDataBroadcast=1</p>
                </div>
            </div>
            <!-- 功能结束 -->
            <!-- 客舱服务 -->
            <div id="tab3" class="tab_content">
                <label> &nbsp;  &nbsp;  &nbsp; 客舱语音音量</label>
                <div id="cabinOutputVolume"></div>
                <div class="clear"></div><!-- 分割 -->
                <br /><br />     <br /><br />
                <style type="text/css">
                    .wrapper {position: relative;}
                    #input {position: absolute;top: 0;left: 0;opacity: 0;z-index: -10;}
                </style>
                <div class="wrapper">
                    <textarea id="input">这是幕后黑手</textarea>
                    <button style="margin-bottom:4px; margin-top:4px; margin-left:3px; margin-right:3px;" onclick="copyText('https://pan.baidu.com/s/1Cf8ifgpKqI8ZH3S1uB_k5w')">下载航空公司语音包</button>
                </div>
                <br /><br />【 航司语音包文件放置路径 】<br />
                &nbsp; &nbsp;E:\HKRS\AVIATION LIFE FOQA\libs\CabinBroadcast_大写公司三字码.zip（无需解压）<br />
                <br /><br />

                <script type="text/javascript">
                    function copyText(content) {
                        text = content;
                        var input = document.getElementById("input");
                        input.value = text; // 修改文本框的内容
                        input.select(); // 选中文本
                        document.execCommand("copy"); // 执行浏览器复制命令
                        alert("复制成功");
                    }
                </script>
            </div>
            <!-- 飞客舱服务结束 -->
            <!-- 匹配进度 -->
            <div id="tab4" class="tab_content">
                <table class="ocean_table" width="100%" border="1px" cellspacing="0" cellpadding="0" align="center"  >
                    <thead>
                    <tr>
                        <th style='background:#EEE9BF;padding:auto;' class="fixtd" width="auto"><center>当前机型数据</center></th>
                        <th style='background:#EEE9BF;padding:auto;' class="fixtd" width="auto"><center>任务机型</center></th>
                        <th style='background:#EEE9BF;padding:auto;' class="fixtd" width="auto"><center>FOQA文件</center></th>
                        <th style='background:#EEE9BF;padding:auto;' class="fixtd" width="auto"><center>匹配状态</center></th>
                    </tr>
                    </thead>
                    <tbody>
                    <style>
                        tr{background:#FFFFFF;}
                        tr:hover{background:#FFFF33;}
                    </style>
                    @inject('vasvc', 'App\Services\VirtualAirlineService')
                    @foreach($vasvc->getAircraftTrackers() as $ac)
                    <tr>
                        <td align="center">{{$ac->aircraft_name}}</td>
                        <td align="center">
                            @empty($ac->aircraft_match_name)
                                ←是否有明确机型
                            @endempty
                            {{  $ac->aircraft_match_name }}
                        </td>
                        <td align="center">
                            @empty($ac->FOQA_name)
                                未匹配FOQA
                            @endempty
                            {{  $ac->FOQA_name }}
                        </td>
                        <td align="center">
                            @if($ac->huhao == 0)
                                <fonts color="Fuchsia">待匹</fonts>
                            @elseif($ac->huhao == 3)
                                完成
                            @elseif($ac->huhao == 1)
                                <fonts color="red">自动</fonts>
                            @else
                                未知
                            @endif
                        </td>
                    </tr>
                    @endforeach
                    </tbody>
                </table>
                <br />【 自动匹配说明 】<br />
                &nbsp; &nbsp;1、自动状态 - 请核对：任务机型、FOQA文件 是否正确； <br />
                &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;匹配正确：可自行重新登机，开始航班；<br />
                &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;未自动匹配：请更换其他涂装或机型执飞航班；<br />
                &nbsp; &nbsp;2、任务机型和当前识别的执飞机型，必须要有明确相同的机型数据显示；否则无法自动匹配<br />
            </div>
            <!-- 匹配进度结束 -->
        </div>
        <!-- 分页开始结束 -->
        <div class="clear"></div><!-- 分割 -->
    </div>
    <!-- 框架内容结束 -->
    <div class="clear"></div>
@endsection
@section('script')
    @parent

    <script type="text/javascript">
        $(window).load(function() {
            $("#uniform-SIDSelect").css("width","250px");
            $("#uniform-STARSelect").css("width","250px");
            $("#uniform-CycleSelect").css("width","110px");
            $("#uniform-CycleSelect").children("span").css("width","100px");
        });

        $( "#cabinOutputVolume" ).slider({
            orientation: "horizontal",
            range: "min",
            max: 100,
            value: 50
        });

        $( "#cabinOutputVolume" ).on( "slide", function( event, ui ) {
            MainWindowJSObject.setCabinVolume(ui.value)
        });

        $("#SIDSelect").click(function(){
            var depicao = $("#depICAOInput").val().toUpperCase();
            if($("#SIDSelect").attr("currentAirport") == depicao)
                return;
            $("#calculateBtn").attr({"disabled":"disabled"});
            $("#SIDSelect").empty();
            $.uniform.update("#SIDSelect");
            var Cycle = $("#CycleSelect").val();
            $("#SIDSelect").attr("currentAirport", depicao);
            $.ajax({
                url:"/RoutePlanner/SimRoutePlannerAPI.php",
                type:"POST",
                data:{action:"GetSIDs", depicao:depicao, Cycle:Cycle},
                dataType: 'json',
                async:true,
                success:function(result){
                    $("#SIDSelect").empty();
                    for(var k in result) {
                        var rwyStr = " | "; //跑道
                        for (var r in result[k].rwys)
                        {
                            rwyStr += " " + result[k].rwys[r];
                        }
                        $("#SIDSelect").append("<option style='left:10px; width: 240px;' value='"+result[k].name+"'>"+result[k].name+ " " +rwyStr+ " | "+ result[k].point + "</option>"); //离场点
                    }
                    $('#calculateBtn').removeAttr("disabled");
                }
            });
        });
        $("#STARSelect").click(function(){
            var arricao = $("#arrICAOInput").val().toUpperCase();
            if($("#STARSelect").attr("currentAirport") == arricao)
                return;
            $("#calculateBtn").attr({"disabled":"disabled"});
            $("#STARSelect").empty();
            $.uniform.update("#STARSelect");
            var Cycle = $("#CycleSelect").val();
            $("#STARSelect").attr("currentAirport", arricao);
            $.ajax({
                url:"/RoutePlanner/SimRoutePlannerAPI.php",
                type:"POST",
                data:{action:"GetSTARs", arricao:arricao, Cycle: Cycle},
                dataType: 'json',
                async:true,
                success:function(result){
                    $("#STARSelect").empty();
                    for(var k in result) {
                        var rwyStr = " | "; //跑道
                        for (var r in result[k].rwys)
                        {
                            rwyStr += " " + result[k].rwys[r];
                        }
                        $("#STARSelect").append("<option style='left:10px; width: 240px;' value='"+result[k].name+"'>"+result[k].name+ " " +rwyStr+ " | "+ result[k].point + "</option>");//进场点
                    }
                    $('#calculateBtn').removeAttr("disabled");
                }
            });
        });
        $("#calculateBtn").click(function(){
            $("#calculateBtn").attr({"disabled":"disabled"});
            var depicao = $("#depICAOInput").val().toUpperCase();
            var arricao = $("#arrICAOInput").val().toUpperCase();
            var SID = $("#SIDSelect").val();
            var STAR = $("#STARSelect").val();
            var Cycle = $("#CycleSelect").val();

            $.ajax({
                url:"/RoutePlanner/SimRoutePlannerAPI.php",
                type:"POST",
                data:{action:"GetRoute", depicao:depicao, arricao:arricao, SID:SID, STAR:STAR, Cycle:Cycle},
                dataType: 'json',
                async:true,
                success:function(result){
                    var rwyStr = "使用跑道";
                    result[2] = JSON.parse(result[2]);
                    result[3] = JSON.parse(result[3]);
                    for (var r in result[2].rwys)
                    {
                        rwyStr += " " + result[2].rwys[r];
                    }
                    var info = "";
                    info += "出发信息 " + result[0] + " | " + rwyStr + " | " + result[2].name + " 离场 | 离场点 "+ result[2].point + "\r\n";
                    var rwyStr = "预计跑道";
                    for (var r in result[3].rwys)
                    {
                        rwyStr += " " + result[3].rwys[r];
                    }
                    info += "途径航点 " + result[5] + "\r\n";
                    info += "到达信息 " + result[1] + " | " + rwyStr + " | " + result[3].name + " 进场 | 进场点 "+ result[3].point + "\r\n";
                    info += "完整航路 " + result[4] + "\r\n";
                    info += "导航数据版本 " + result[7] + "\r\n";
                    info += "查询次数 " + result[8] + "\r\n";
                    $("#routeInfo").val(info);
                    $("#flightDistance").val(result[6]);
                    $('#calculateBtn').removeAttr("disabled");
                }
            });
        });
    </script>
@endsection