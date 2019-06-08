@extends('dashboard.layout')
@section('title')
    加入我们
@endsection
@section('page-name')
    加入我们
@endsection
@section('content')
    <div class="row">
        <div class="card">
            <div class="card-title p-3 text-info">
                QQ群组 (点击按钮复制群号)
            </div>
            <div class="card-body">
                <button style="margin-bottom:8px; margin-top:8px;" onclick="copyText('30253708')">航空人生 模拟飞行</button>
                <button style="margin-bottom:8px; margin-top:8px;" onclick="copyText('372807361')">官方 联飞群</button>
                <button style="margin-bottom:8px; margin-top:8px;" onclick="copyText('228425134')">飞行学院</button>
                <button style="margin-bottom:8px; margin-top:8px;" onclick="copyText('601219163')">空管管制学院</button>
                <button style="margin-bottom:8px; margin-top:8px;" onclick="copyText('117175590')">Prepar3D</button>
                <button style="margin-bottom:8px; margin-top:8px;" onclick="copyText('141097498')">X-Plane</button>
                <button style="margin-bottom:8px; margin-top:8px;" onclick="copyText('131057650')">FlightGear</button>
                <button style="margin-bottom:8px; margin-top:8px;" onclick="copyText('636466140')">平台接入合作</button>
            </div>
        </div>
    </div>
    <div class="w-100"></div>

    <div class="row">
        <div class="card my-3">
            <div class="card-title p-3 text-info">
                媒体 (点击按钮复制信息)
            </div>
            <div class="card-body">
                <button style="margin-bottom:8px; margin-top:8px;" onclick="copyText('http://blog.sina.com.cn/u/2047418611')">
                    <img width='140' height='140' src="{{ asset('assets/images/joinus/Sina.png') }}"/><br />新浪微博
                </button>

                <button style="margin-bottom:8px; margin-top:8px;" onclick="copyText('官方指定远程协助解决问题工具 TeamViewer 百度网盘链接:https://pan.baidu.com/s/1qXXIDo4  密码:xts1')">
                    <img width='140' height='140' src="{{ asset('assets/images/joinus/TeamViewer.png') }}"/><br />远程协助
                </button>

                <button style="margin-bottom:8px; margin-top:8px;" onclick="copyText('admin@hkrscoc.com')">
                    <img width='140' height='140' src="{{ asset('assets/images/joinus/Email.png') }}"/><br />电子邮件
                </button>

                <button style="margin-bottom:8px; margin-top:8px;" onclick="copyText('https://join.skype.com/zA2iYqh3qEKq')">
                    <img width='140' height='140' src="{{ asset('assets/images/joinus/skype.png') }}"/><br />Skype
                </button>

                <button style="margin-bottom:8px; margin-top:8px;"onclick="copyText('hangkongrensheng')">
                    <a href="{{ asset('assets/images/joinus/dingyue.jpg') }}" target="_blank">
                        <img width='140' height='140' src="{{ asset('assets/images/joinus/dingyue.jpg') }}"/><br />微信订阅号
                    </a>
                </button>

                <button style="margin-bottom:8px; margin-top:8px;"onclick="copyText('chinaflier')">
                    <a href="{{ asset('assets/images/joinus/fuwu.jpg') }}" target="_blank">
                        <img width='140' height='140' src="{{ asset('assets/images/joinus/fuwu.jpg') }}"/><br />微信公众号
                    </a>
                </button>

                <br /> <br />

            </div>
        </div>
    </div>
    <textarea id="input" class="d-none"></textarea>
@endsection
@section('script')
    <script>
        function copyText(content) {
            text = content;
            var input = document.getElementById("input");
            input.value = text; // 修改文本框的内容
            input.select(); // 选中文本
            document.execCommand("copy"); // 执行浏览器复制命令
            alert("复制成功，粘贴至相关程序或浏览器中使用");
        }
    </script>
@endsection