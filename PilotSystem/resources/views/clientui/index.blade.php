@extends('clientui.frame')
@section('title')
    主页
@endsection
@section('submain')
    <div class="widget chartWrapper" ondragstart="return false;">
        <ul class="tabs">
            <li><a onmousedown="return false" href="#tab1">新闻公告 | News</a></li>
            <li><a onmousedown="return false" href="#tab2">航空公司 | Airlines</a></li>
            <li><a onmousedown="return false" href="#tab3">直播大厅 | Live</a></li>
            <li><a onmousedown="return false" href="#tab4">QQ群 | Group</a></li>
        </ul>
        <!-- 分页开始 -->
        <div class="tab_container">
            <!-- 分页1 -->
            <div id="tab1" class="tab_content">
                <div style="height: 450px;"><!-- 居中 -->
                    <div id="新闻"></div>
                    <div class="line"></div><!-- 分割 -->
                    <div id="连飞"></div>
                    <div class="line"></div><!-- 分割 -->
                    <div id="航司动态"></div>
                    <div class="line"></div><!-- 分割 -->
                    <div id="飞行员"></div>
                    <div class="line"></div><!-- 分割 -->
                    <div id="飞行资料"></div>
                    <div class="line"></div><!-- 分割 -->
                    <div id="签到"></div>
                </div>
            </div>
            <!-- 分页1结束 -->
            <!-- 分页2 -->
            <div id="tab2" class="tab_content">
                <div style="height: 450px;"><!-- 居中 -->
                    <iframe src="{{ route('clientui.news', 'airlines') }}" scrolling="yes" style="width:500px; height:450px;"></iframe>
                </div>
            </div>
            <!-- 分页2结束 -->
            <!-- 分页3 -->
            <div id="tab3" class="tab_content">
                <div style="height: 450px;"><!-- 居中 -->
                    <iframe src="{{ route('clientui.news', 'zhibo') }}" scrolling="yes" style="width:500px; height:450px;"></iframe>
                </div>
            </div>
            <!-- 分页3结束 -->
            <!-- 分页4 -->
            <div id="tab4" class="tab_content">
                <div style="height: 450px;"><!-- 居中 -->
                    <iframe src="{{ route('clientui.news', 'qq') }}" scrolling="yes" style="width:500px; height:450px;"></iframe>
                </div>
            </div>
            <!-- 分页4结束 -->
        </div>
        <!-- 分页开始结束 -->
        <div class="clear"></div><!-- 分割 -->
    </div>
    <!-- 框架内容结束 -->
    <div class="clear"></div>
@endsection
@section('script')
    @parent

    <script type="text/javascript" src="{{ asset('assets/js/client/postscribe.min.js') }}"></script>
    <script type="text/javascript">
        window.onload = function(){
            setTimeout(loadAfterTime, 0.1)
        };

        function loadAfterTime() {
            postscribe('#新闻', "<script src='https://bbs.hkrscoc.com/api.php?mod=js&bid=8' async><\/script>");
            postscribe('#连飞', "<script src='https://bbs.hkrscoc.com/api.php?mod=js&bid=15' async><\/script>");
            postscribe('#航司动态', "<script src='https://bbs.hkrscoc.com/api.php?mod=js&bid=13' async><\/script>");
            postscribe('#飞行员', "<script src='https://bbs.hkrscoc.com/api.php?mod=js&bid=7' async><\/script>");
            postscribe('#飞行资料', "<script src='https://bbs.hkrscoc.com/api.php?mod=js&bid=18' async><\/script>");

            postscribe('#签到', "<script src='https://bbs.hkrscoc.com/api.php?mod=js&bid=12' async><\/script>");
          
          
        }
    </script>
@endsection