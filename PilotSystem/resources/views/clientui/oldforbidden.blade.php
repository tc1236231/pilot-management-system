@extends('clientui.frame')
@section('title')
    主页
@endsection
@section('submain')
    <div class="widget chartWrapper" ondragstart="return false;">
        <h1 style="padding: 100px;line-height:40px;">由于分家事件,旧飞行员系统数据已经无法再次使用,但我们保留了旧飞行员系统数据,请前往bbs.hkonc.cn通过导入旧呼号方式来注册新呼号,给您带来的不便敬请谅解!具体分家事件请见www.hkonc.cn或Q群30253708 如果已经注册,请在客户端登录时选择新系统接入</h1>
        <div class="clear"></div><!-- 分割 -->
    </div>
    <!-- 框架内容结束 -->
    <div class="clear"></div>
@endsection
@section('script')
    @parent

@endsection