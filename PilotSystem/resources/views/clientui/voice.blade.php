@extends('clientui.frame')
@section('title')
    语音设置
@endsection
@section('submain')
    <!-- 框架内容 -->
    <div class="widget" ondragstart="return false;">
        <div class="title"><img src="{{asset('assets/images/client/icons/dark/imageList.png')}}" alt="" class="titleIcon" /><h6>语音设置 | Voice</h6></div>

        <div class="wrapper statsItems"><!-- 居中 -->
            <div class="formRow">
                <h4 style="margin-bottom: 10px;">本地机模语音组件数据</h4>
                <div id="localVoiceInfo">
                    暂无
                </div>
            </div>
            <div class="formRow"><h4><a id="PTTKeyLabel" title="" class="value"></a></h4></div><br />
            <a class="button greenB" onclick="configurePTTKey()" style="margin: 5px;"><span>自定义通话键</span></a>
            <a class="button blackB" onclick="testVoice()" ><span>语音测试开关</span></a> <br />
            <h4 style="color: red">使用说明</h4>
            自定义通话键：单机自定义按钮 → 操作（键盘、摇杆）上的通话按键。  <br />
            语音测试开关，测试本地通话，再次单击关闭测试语音<br />
            断开语音、或被管制踢出语音后，需要重新连线，加入语音通信； <br />
        </div>
        <div class="line"></div><!-- 分割 --><br />
        <frame>
        <div class="formRight">
            <label> &nbsp;  &nbsp;  &nbsp; 输出设备</label>
            <div class="floatL"><select onchange="selectOutputDevice()" id="outputDevice" class="validate" ></select></div><br />
            <br /><br />
            <!--    <label> &nbsp;  &nbsp;  &nbsp; 输出音量</label>
                    <div id="outputVolume" class="uiMinRange"></div> -->
            <div class="line"></div><!-- 分割 --><br />
            <label> &nbsp;  &nbsp;  &nbsp; 输入设备</label>
            <div class="floatL"><select onchange="selectInputDevice()" id="inputDevice" class="validate" ></select></div><br /><br />
            <!--<label> &nbsp;  &nbsp;  &nbsp; 输入音量</label>
                <div class="uiMinRange"></div> -->
        </div>
        </frame><br />

    </div>
    <!-- 框架内容结束 -->
    <div class="clear"></div>
@endsection
@section('script')
    @parent

    <script type="text/javascript" src="{{ asset('assets/js/client/voice.js') }}"></script>
@endsection