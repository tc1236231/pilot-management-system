@extends('clientui.frame')
@section('title')
    连飞中心
@endsection
@section('submain')
    <!-- 框架内容 -->
    <div class="widget chartWrapper" ondragstart="return false;">
        <ul class="tabs">
            <li><a href="#tab1">管制席位 | ATC Position</a></li>
            <li><a href="#tab2">终端情报 | ATIS</a></li>
            <li><a href="#tab3">活动管理 | Activity</a></li>
            @if(Auth::user()->manageATC)
            <li><a href="#tab4">人员管理 | Management</a></li>
            @endif
        </ul>
        <!-- 分页开始 -->
        <div class="tab_container">
            <!-- 管制席位1 -->
            <div id="tab1" class="tab_content">
                <div class="leftPart">
                    <select id="freqList" multiple="multiple" class="multiple" style="height:200px;"></select>
                </div>
                <div class="rightPart">
                    <select id="clientList" multiple="multiple" class="multiple" style="height:200px;"></select>
                </div>
                <div class="line"></div>
                <div class="statsItems">
                    <a>当前频率</a><br />
                    <a id="freqLabel" class="value">未连接</a>
                </div>
                <div class="line"></div><br />
                <input onclick="toggleATCTS()" class="dredB" value="连接 / 断开通讯" type="reset" />
                <div class="line"></div>
                <div class="statsItems">
                    <a> - ATC 协调频率 - </a>
                    <a id="freqLabel" class="value">129.999</a><br />
                    <a> - 航司公用频率 - </a>
                    <a id="freqLabel" class="value">XXX.000</a>
                </div>
                <div class="formRow">
                    <div class="formRight">席位频率:
                        <input id="frequencyCreatedText" type="text" class="required" maxlength="7" placeholder="000.000" name="customMessage" id="customMessage"/>
                        &nbsp; &nbsp;
                        <input onclick="createFrequency()" class="brownB" value="创建席位" type="reset" />
                        &nbsp; &nbsp;
                        <input onclick="deleteFrequency()" class="basic" value="删除频率" type="reset" />
                    </div>
                    <br />
                </div>
                <b>注意事项</b> <br />
                &nbsp; &nbsp; &nbsp; &nbsp;* * 活动前，请修改设置《当前活动状态》，未获取官方连飞资格，将无法连线飞行;<br />
                &nbsp; &nbsp; &nbsp; &nbsp;1、 连接通讯，创建 ATIS 频道, (ATC\COM1\COM2同时连接语音,则送话讲会失效);<br />
                &nbsp; &nbsp; &nbsp; &nbsp;2、 例如: 新建ATIS频道: 125.275, ATIS文件名为: 125275.wav ;<br />
                &nbsp; &nbsp; &nbsp; &nbsp;3、 将新的 125275.wav 文件放在客户端主目录下的ATIS文件夹内,选择文件上传;<br />
                &nbsp; &nbsp; &nbsp; &nbsp;4、 双击右侧飞行员即可踢出语音服务器； <br />
                &nbsp; &nbsp; &nbsp; &nbsp;5、 管制指令： _ 代表 空格 <br />
                &nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp;定位点（.rcenter_ZBAA）,私聊（.msg_呼号_内容）,广播（.wall_内容）; <br />
            </div>
            <!-- 管制席位结束 -->
            <!-- 终端情报 -->
            <div id="tab2" class="tab_content">
                <div class="formRow">
                    机组接收文本 ATIS 频率: <input type="text" class="required" placeholder="000.000" maxlength="7" name="customMessage" id="customMessage"/>

                    <br />	<br />
                    <textarea placeholder="输入要上传 ATIS 文本" id="txt" style="height:250px; width:500px; resize: none;"></textarea>
                    <br /><br />
                    <input class="dredB" value="上传文本" id="updatetxt" type="button" /><br />	<br />
                    <a onmousedown="return false" href="https://pan.baidu.com/s/16gEGG6NviGbchUUwzHcPJQ" target="_blank" >
                        <input id="" class="basic" value="下载 ATIS 模板" type="reset" /></a>  &nbsp;
                    PassWord: d j n g  禁止对外公开
                </div><br /><br /><br /><br /><br />
            </div>
            <!-- 终端情报结束 -->
            <!-- 活动管理 -->
            <div id="tab3" class="tab_content">
                <a>当前连线模式：</a>
                <a id="currentRestrictStatus" class="value">
                    @if(!$restrict->ip)
                        无限制状态 - 全体任何人均可连线飞行
                    @else
                        有限制状态 - 未获取连飞资格禁止连线
                    @endif
                </a>{{$restrict->uptime}} &nbsp; &nbsp; {{$restrict->ussvname}}
                <br /><br />
                <select id="restrictStatus" name="select1" >
                    <option value="0">无限制连线 - 全体可连接</option>
                    <option value="1">有限制连线 - 部分可连接</option>
                </select>
                &nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp;
                <input id="changeRestrictStatusBtn" class="brownB" value="保存活动状态" type="reset" />
                <br /><br />
                <b>注意事项</b> <br /><br />
                &nbsp; &nbsp; &nbsp; &nbsp;* * 活动结束后，请修改恢复设置《当前活动状态》; <br />
            </div>
            <!-- 活动管理结束 -->
            @if(Auth::user()->manageATC)
            <div id="tab4" class="tab_content">
                <div>
                    输入操作呼号:<input type="text" class="required" placeholder="0000" maxlength="4" name="input_callsign" id="input_callsign"/>
                    <input id="queryCallsignStatusBtn" class="brownB" value="查询" type="button" />
                </div>
                <div style="margin-top: 10px; display: none;" id="callsign_info">
                    <div id="callsign_info_txt">0000 连飞资格 管制等级</div>
                    <input id="currentCallsign" value="" type="hidden" />
                    <input id="banCallsignBtn" class="redB" value="禁飞封号" type="button" />
                    <input id="unbanCallsignBtn" class="greenB" value="解封" type="button" />
                    <select id="atcLevel" name="atcselect" >
                        <option value="2">实习管制</option>
                        <option value="3">地面管制</option>
                        <option value="4">塔台管制</option>
                        <option value="5">离场管制</option>
                        <option value="6">进近管制</option>
                        <option value="7">区调管制</option>
                    </select>
                    <input id="changeATCCallsignBtn" class="dblueB" value="等级变更" type="button" />
                </div>
                <div style="overflow: auto; height: 250px; border: 1px solid #666; margin-bottom: 20px; padding: 5px; padding-top: 0px; padding-bottom: 20px; margin-top: 20px;">
                    <h5 style="text-align: center;">近期操作日志</h5>
                    <table id="mytable" width="100%" border="0" cellspacing="0" cellpadding="0" class="ocean_table">
                        <thead>
                        <tr>
                            <th><center>被操作呼号</center></th>
                            <th><center>操作内容</center></th>
                            <th><center>操作人呼号</center></th>
                            <th><center>时间</center></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($logs as $log)
                            <tr>
                                <td align="center">{{ $log->callsign }}</td>
                                <td align="center">{{ $log->content }}</td>
                                <td align="center">{{ $log->admin }}</td>
                                <td align="center">{{ $log->time }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            @endif
        </div>
        <!-- 分页开始结束 -->
        <div class="clear"></div><!-- 分割 -->
    </div>
    <!-- 框架内容结束 -->
    <div class="clear"></div>
@endsection
@section('script')
    @parent

    <script type="text/javascript" src="{{ asset('assets/js/client/atc.js') }}"></script>

    <script>
        $("#updatetxt").click(function(){
            var freq = $.trim($("#customMessage").val());
            var txt = $.trim($("#txt").val());

            $.ajax({
                url:"{{ route('api.atc.atis.create')  }}",
                type:"POST",
                async:true,
                data:{"freq":freq,"txt":txt},
                success:function(data){
                    if($.trim(data)=="success"){
                        swal("成功","上传成功!","success");
                    }
                    else
                    {
                        swal("错误","上传失败!","error");
                    }
                },
                error: function(xhr, textStatus, errorThrown) {
                    swal("错误","上传失败:" + errorThrown + ' ' + xhr.responseText,"error");
                }
            });
        });

        $("#changeRestrictStatusBtn").click(function(){
            var status = $.trim($("#restrictStatus").val());

            $.ajax({
                url:"{{ route('api.atc.restrict.status.change')  }}",
                type:"POST",
                async:true,
                data:{"status":status},
                success:function(data){
                    if($.trim(data)=="success"){
                        swal("成功","修改成功!","success");
                        $("#currentRestrictStatus").html($("#restrictStatus option:selected").text());
                    }
                    else
                    {
                        swal("错误","修改失败!","error");
                    }
                },
                error: function(xhr, textStatus, errorThrown) {
                    swal("错误","修改失败:" + errorThrown + ' ' + xhr.responseText,"error");
                }
            });
        });

        $("#queryCallsignStatusBtn").click(function(){
            var callsign = $.trim($("#input_callsign").val());
            $('#callsign_info').hide();

            $.ajax({
                url:"{{ route('api.atc.callsign.query')  }}",
                type:"GET",
                async:true,
                data:{"callsign":callsign},
                dataType: "json",
                success:function(data){
                    if($.trim(data.status)=="success"){
                        $('#banCallsignBtn').hide();
                        $('#unbanCallsignBtn').hide();
                        $('#changeATCCallsignBtn').hide();
                        if(data.actions.includes('ban'))
                            $('#banCallsignBtn').show();
                        if(data.actions.includes('unban'))
                            $('#unbanCallsignBtn').show();
                        if(data.actions.includes('mod'))
                            $('#changeATCCallsignBtn').show();
                        $('#currentCallsign').val(data.callsign);
                        $('#callsign_info_txt').html(data.callsign + " " + data.flight_perm + " " + data.atc_level);
                        $('#callsign_info').show();
                    }
                    else
                    {
                        swal("错误","查询失败!","error");
                    }
                },
                error: function(xhr, textStatus, errorThrown) {
                    swal("错误","查询失败:" + errorThrown + ' ' + JSON.parse(xhr.responseText),"error");
                }
            });
        });

        $("#banCallsignBtn").click(function(){
            var callsign = $.trim($("#currentCallsign").val());
            $('#callsign_info').hide();

            $.ajax({
                url:"{{ route('api.atc.callsign.ban')  }}",
                type:"GET",
                async:true,
                data:{"callsign":callsign},
                dataType: "json",
                success:function(data){
                    if($.trim(data.status)=="success"){
                        swal("成功","封禁成功!","success");
                    }
                    else
                    {
                        swal("错误","封禁失败!","error");
                    }
                },
                error: function(xhr, textStatus, errorThrown) {
                    swal("错误","封禁失败:" + errorThrown + ' ' + JSON.parse(xhr.responseText),"error");
                }
            });
        });

        $("#unbanCallsignBtn").click(function(){
            var callsign = $.trim($("#currentCallsign").val());
            $('#callsign_info').hide();

            $.ajax({
                url:"{{ route('api.atc.callsign.unban')  }}",
                type:"GET",
                async:true,
                data:{"callsign":callsign},
                dataType: "json",
                success:function(data){
                    if($.trim(data.status)=="success"){
                        swal("成功","解封成功!","success");
                    }
                    else
                    {
                        swal("错误","解封失败!","error");
                    }
                },
                error: function(xhr, textStatus, errorThrown) {
                    swal("错误","解封失败:" + errorThrown + ' ' + JSON.parse(xhr.responseText),"error");
                }
            });
        });

        $("#changeATCCallsignBtn").click(function(){
            var callsign = $.trim($("#currentCallsign").val());
            var atc_level = $.trim($("#atcLevel").val());
            $('#callsign_info').hide();

            $.ajax({
                url:"{{ route('api.atc.callsign.mod')  }}",
                type:"GET",
                async:true,
                data:{"callsign":callsign, "level": atc_level},
                dataType: "json",
                success:function(data){
                    if($.trim(data.status)=="success"){
                        swal("成功","修改成功!","success");
                    }
                    else
                    {
                        swal("错误","修改失败!","error");
                    }
                },
                error: function(xhr, textStatus, errorThrown) {
                    swal("错误","修改失败:" + errorThrown + ' ' + JSON.parse(xhr.responseText),"error");
                }
            });
        });
    </script>
@endsection