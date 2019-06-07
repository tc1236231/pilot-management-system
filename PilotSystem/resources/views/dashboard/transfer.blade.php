@extends('dashboard.layout')
@section('title')
    货币转换
@endsection
@section('page-name')
    货币转换
@endsection
@section('content')
    <div class="row">
        <h5 style='text-align:center;font-size:20px;'>飞行币转换至其他合作平台 <br /> 目前该功能仅供官方论坛绑定使用~ P3D / XP 论坛升级中...</h5>
    </div>
@endsection
@section('script')
    <script>
        $("form").submit(function (e) {
            if ($(this).attr("attempted") === 'true' ) {
                e.preventDefault();
            }
            else {
                $(this).attr("attempted", 'true');
            }
        });
    </script>
@endsection