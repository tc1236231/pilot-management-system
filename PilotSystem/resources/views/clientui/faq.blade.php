@extends('clientui.frame')
@section('title')
    FAQ
@endsection
@section('submain')
    <!-- 框架内容 -->
    <div class="widget" ondragstart="return false;">
        <style type="text/css">
            .wrapper {position: relative;}
            #input {position: absolute;top: 0;left: 0;opacity: 0;z-index: -10;}
        </style>
        <textarea id="input">这是幕后黑手</textarea>

        <ul class="tabs">
            <li><a href="#tab1">常见问题 | FAQ</a></li>
            <li><a href="#tab2">飞行教程 | Flight</a></li>
            <li><a href="#tab3">管理中心 | Admin</a></li>
        </ul>
        <!-- 分页开始 -->
        <div class="tab_container">
            <!-- 分页1 -->
            <div id="tab1" class="tab_content">
                <div class="wrapper statsItems">
                    <button onclick="copyText('https://cloud.video.taobao.com//play/u/2334173164/p/1/e/6/t/1/50058848500.mp4')">航空人生介绍</button>&nbsp; &nbsp;
                    <button onclick="copyText('https://cloud.video.taobao.com//play/u/2334173164/p/1/e/6/t/1/50062070243.mp4')">航空人生教程</button>
                    <br /><br />
                    <div class="line"></div> <br />
                    <button onclick="copyText('http://bbs.hkonc.cn/forum.php?mod=viewthread&tid=31231')">客户端 问题解答</button>&nbsp; &nbsp;
                    <button onclick="copyText('http://bbs.hkonc.cn/forum.php?mod=viewthread&tid=27480')">机模 AI 帮助</button>&nbsp; &nbsp;
                    <button onclick="copyText('http://va.hkonc.cn/index.php/faq')">虚航问题解答</button>
                    <br /><br />
                    <button onclick="copyText('https://pan.baidu.com/s/15OwumJsuNTkVwPdXRFZX6A 提取码:8hc6')">主安装程序 | 安装说明 | 客舱语音包 | XP-FF359识别修复补丁</button>
                    <br /><br />
                    <button onclick="copyText('https://pan.baidu.com/s/1o8UdWOM 提取码:mki3')">ChinaFlier Client AI FSX P3D 版 - 仅支持 FSX P3D</button>
                    <br /><br />
                    <button onclick="copyText('https://pan.baidu.com/s/1hsaL6vU 提取码:zgmv')">ChinaFlier Client AI X-PLANE 版 - 仅支持 X-PLANE</button>
                    <br /><br />
                    <button onclick="copyText('https://pan.baidu.com/s/1qXXIDo4 提取码:xts1')">Team Viewer CFR官方专用远程帮助工具</button>
                    <br /><br />
                    <button onclick="copyText('http://bbs.hkonc.cn/forum.php?mod=forumdisplay&fid=339')">其他各种插件安装视频教程</button>
                </div>
                <br />
                <div class="line"></div> <br />
                <div class="wrapper statsItems">
                    @if(!Auth::user()->banned)
                        <button onclick='MainWindowJSObject.updateXPlanePlugin();'>X-PLANE 错误修正 Bug Fixes | 校验基础接口文件(校验时将自动关闭模拟器)</button>
                    @endif
                </div>
            </div>
        </div>
        <!-- 分页1结束 -->
        <!-- 分页2 -->
        <div id="tab2" class="tab_content">
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
            <h5>虚航说明</h5>
            &nbsp; 1、 必须仔细阅读 【 航空人生 问题解答 运营规定 说明 .pdf 】； <br />

            <br /><br />
        </div>
        <!-- 分页2结束 -->

        <!-- 分页3 -->
        <div id="tab3" class="tab_content">
            <div class="wrapper statsItems"><!-- 居中 -->
                @if(Auth::user()->callsign == "8928" || Auth::user()->callsign == "3804")
                    <button onclick=MainWindowJSObject.showPointSystemEditForm();''>FOQA 编辑中心</button>
                @endif
            </div>
        </div>
        <!-- 分页3结束 -->
    </div>
    <!-- 分页开始结束 -->

    <div class="clear"></div><!-- 分割 -->

    <script type="text/javascript">
        function copyText(content) {
            // var text = document.getElementById("text").innerText;
            text = content;
            var input = document.getElementById("input");
            input.value = text; // 修改文本框的内容
            input.select(); // 选中文本
            document.execCommand("copy"); // 执行浏览器复制命令
            alert("复制成功，粘贴至浏览器打开");
        }
    </script>
    <!-- 框架内容结束 -->
    <div class="clear"></div>
@endsection
@section('script')
    @parent

@endsection