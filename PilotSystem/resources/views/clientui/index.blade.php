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
                    <div id="zongju"></div>
                    <div class="line"></div><!-- 分割 -->
                    <div id="jingpai"></div>
                    <div class="line"></div><!-- 分割 -->
                    <div id="lianfei"></div>
                    <div id="feiyuan"></div>
                    <div id="hangsi"></div>
                    <div id="zhaopin"></div>
                    <div class="line"></div><!-- 分割 -->
                    <div id="weigui"></div>
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
            postscribe('#zongju', "<script src='http://bbs.chinaflier.com/api.php?mod=js&bid=309' async><\/script>");
            postscribe('#jingpai', "<script src='http://bbs.chinaflier.com/api.php?mod=js&bid=315' async><\/script>");
            postscribe('#lianfei', "<script src='http://bbs.chinaflier.com/api.php?mod=js&bid=312' async><\/script>");
            postscribe('#feiyuan', "<script src='http://bbs.chinaflier.com/api.php?mod=js&bid=310' async><\/script>");
            postscribe('#hangsi', "<script src='http://bbs.chinaflier.com/api.php?mod=js&bid=306' async><\/script>");
            postscribe('#zhaopin', "<script src='http://bbs.chinaflier.com/api.php?mod=js&bid=307' async><\/script>");
            postscribe('#weigui', "<script src='http://bbs.chinaflier.com/api.php?mod=js&bid=313' async><\/script>");
        }
    </script>
@endsection