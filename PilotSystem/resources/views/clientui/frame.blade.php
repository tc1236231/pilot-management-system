@extends('clientui.base')
@section('main')
    <div class="wrap">
        <!-- Left side content -->
    @include('clientui.leftbar')

    <!-- 顶部框架 -->
        <div id="rightSide">
            <!-- 顶部导航 -->
            @include('clientui.topbar')
            <!-- 顶部导航结束 -->
            @yield('submain')
        </div>
        <!-- 顶部框架结束 -->
    </div>
@endsection
@section('script')
    <script type="text/javascript">
        function showLocale(objD)
        {
            var str;
            var hh = objD.getUTCHours();
            if(hh<10) hh = '0' + hh;
            var mm = objD.getUTCMinutes();
            if(mm<10) mm = '0' + mm;
            var ss = objD.getUTCSeconds();
            if(ss<10) ss = '0' + ss;
            str = hh + ":" + mm + ":" + ss + " " ;
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