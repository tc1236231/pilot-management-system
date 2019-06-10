<div id="leftSide">
    <div class="logo" onmousemove="onCanvasMouseMove(event)" onmousedown="onCanvasMouseDown(event); return false;"><img src="{{ asset('assets/images/client/loginLogo.png') }}" alt="" style=" width: 200px;" /></div>
    <div class="sidebarSep" style="margin-top: 10px; margin-bottom: 10px;"></div>

    <!-- 顶部按钮-->
    <div class="iconsGroup" onmousedown="return false" style="margin-top: 6px; margin-bottom: 6px;">
        <ul>
            <li><a onclick="onMessageBoxBtnClicked()" class="dUsers"></a></li>
            <li><a onclick="onRadarBtnClicked()" class="dMessages"></a></li>
            <li id="TransponderStatus"><a onclick="switchTransponderStatus()" class="dMoney"></a></li>
        </ul>
        <div class="clear"></div>
    </div>
    <div class="sidebarSep" onmousedown="return false" style="margin-top: 10px; margin-bottom: 10px;"></div>
    <div onmousedown="return false" style="margin-bottom: 10px; text-align:center;font-size:20px;font-weight:bold;color:White">
        <div class="form-group"><label for="name">UTC </label><span id="ntime"></span></div>
    </div>

    <!-- 菜单导航 -->
    <ul id="menu" class="nav" ondragstart="return false;">
        <li class="dash"><a href="{{ route('clientui.index') }}" class=""><span>新闻公告 | News</span></a></li>
        @if(!Auth::user()->banned)
            <li class="typo"><a href="{{ route('clientui.vip') }}"><span>会员专区 | VIP</span></a></li>
        @endif
        <li class="files"><a href="{{ route('clientui.flightcenter') }}"><span>连飞中心 | Flight</span></a></li>
        <li class="typo"><a href="{{ route('clientui.vaflight') }}"><span>航司运营 | Airlines VA</span></a></li>
        @if(Auth::user()->isatc)
            <li class="charts"><a href="{{ route('clientui.atc') }}"><span>空管中心 | ATC</span></a></li>
        @endif
        <li class="ui"><a href="{{ route('clientui.voice') }}"><span>语音设置 | Voice</span></a></li>
        <li class="widgets"><a href="{{ route('clientui.faq') }}"><span>帮助教程 | Help FAQ</span></a></li>
    </ul>
</div>
