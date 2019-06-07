<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
        <li class="nav-item nav-category">
            <a class="nav-link" data-toggle="collapse" href="#ui-basic" aria-expanded="false" aria-controls="ui-basic">
                <span class="menu-title">飞行员功能</span>
                <i class="icon-speedometer menu-icon"></i>
            </a>
            <div class="collapse" id="ui-basic">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"> <a class="nav-link" href="{{ route('frontend.dashboard.index') }}">基本信息</a></li>
                    <li class="nav-item"> <a class="nav-link" href="{{ route('frontend.dashboard.bind') }}">论坛绑定</a></li>
                    <li class="nav-item"> <a class="nav-link" href="{{ route('frontend.dashboard.va') }}">航空人生</a></li>
                    <li class="nav-item"> <a class="nav-link" href="{{ route('frontend.dashboard.profile') }}">个人信息</a></li>
                    <li class="nav-item"> <a class="nav-link" href="{{ route('frontend.dashboard.redeem') }}">货币兑换</a></li>
                    <li class="nav-item"> <a class="nav-link" href="{{ route('frontend.dashboard.transfer') }}">货币转换</a></li>
                </ul>
            </div>
        </li>
        @if(Auth::user()->level >= 4 && Auth::user()->level <= 8)
            <li class="nav-item nav-category">
                <a class="nav-link" data-toggle="collapse" href="#atc" aria-expanded="false" aria-controls="ui-basic">
                    <span class="menu-title">管制员功能</span>
                    <i class="icon-earphones-alt menu-icon"></i>
                </a>
                <div class="collapse" id="atc">
                    <ul class="nav flex-column sub-menu">
                        <li class="nav-item"> <a class="nav-link" href='{{ route('frontend.dashboard.admin.index') }}'>呼号管理</a></li>
                    </ul>
                </div>
            </li>
        @endif
        @if(Auth::user()->level >= 9)
            <li class="nav-item nav-category">
                <a class="nav-link" data-toggle="collapse" href="#admin" aria-expanded="false" aria-controls="ui-basic">
                    <span class="menu-title">管理员功能</span>
                    <i class="icon-people menu-icon"></i>
                </a>
                <div class="collapse" id="admin">
                    <ul class="nav flex-column sub-menu">
                        <li class="nav-item"> <a class="nav-link" href='{{ route('frontend.dashboard.admin.index') }}'>呼号管理</a></li>
                        @if(Auth::user()->level >= 11)
                            <li class="nav-item"> <a class="nav-link" href='{{ route('frontend.dashboard.admin.redeem') }}'>兑换生成</a></li>
                        @endif
                        @if(Auth::user()->level >= 12)
                            <li class="nav-item"> <a class="nav-link" href="{{ route('frontend.dashboard.admin.log') }}">日志浏览</a></li>
                        @endif
                    </ul>
                </div>
            </li>
        @endif
        <li class="nav-item nav-category">
            <a class="nav-link" data-toggle="collapse" href="#help" aria-expanded="false" aria-controls="ui-basic">
                <span class="menu-title">飞行员入口</span>
                <i class="icon-plane menu-icon"></i>
            </a>
            <div class="collapse" id="help">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"> <a class="nav-link" href="{{ route('frontend.dashboard.link.flightrule') }}">连飞规定</a></li>
                    <li class="nav-item"> <a class="nav-link" target="_blank" href="http://bbs.chinaflier.com/thread-31231-1-1.html">软件下载</a></li>
                    <li class="nav-item"> <a class="nav-link" href="{{ route('frontend.dashboard.link.joinus') }}">加入我们</a></li>
                </ul>
            </div>
        </li>
        <li class="nav-item nav-category">
            <a class="nav-link" data-toggle="collapse" href="#rank" aria-expanded="false" aria-controls="ui-basic">
                <span class="menu-title">排名大数据</span>
                <i class="icon-graph menu-icon"></i>
            </a>
            <div class="collapse" id="rank">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"> <a class="nav-link" href="{{ route('frontend.dashboard.rank.pilot') }}">飞行员排名</a></li>
                    <li class="nav-item"> <a class="nav-link" href="{{ route('frontend.dashboard.rank.atc') }}">管制员排名</a></li>
                    <li class="nav-item"> <a class="nav-link" href="{{ route('frontend.dashboard.rank.platform') }}">各平台排名</a></li>
                </ul>
            </div>
        </li>
    </ul>
</nav>