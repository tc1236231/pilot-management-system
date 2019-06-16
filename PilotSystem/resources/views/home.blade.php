@extends('base')
@section('title')
    主页
@endsection
@section('head')
    <style>
        html, body {
            color: #636b6f;
            font-family: 'Nunito', sans-serif;
            font-weight: 200;
            height: 100vh;
            margin: 0;
        }

        .full-height {
            height: 100vh;
        }

        .flex-center {
            align-items: center;
            display: flex;
            justify-content: center;
        }

        .position-ref {
            position: relative;
        }

        .content {
            text-align: center;
        }

        .title {
            color: white;
            font-weight: bold;
            font-size: 84px;
        }

        .links > a {
            color: #636b6f;
            font-size: 13px;
            font-weight: 600;
            letter-spacing: .1rem;
            text-decoration: none;
            text-transform: uppercase;
        }

        .m-b-md {
            margin-bottom: 30px;
        }
    </style>
@endsection
@section('main')
    <div class="content-wrapper full-page-wrapper align-items-center auth login-full-bg">
        <div class="flex-center position-ref full-height">
            <div class="content">
                <div class="title m-b-md">
                    <img class="img-fluid" src="{{ asset('assets/images/main_title.png') }}" alt="Main Title">
                </div>
                @if (Route::has('login'))
                    <div class="links">
                        @auth
                            <a class="btn btn-primary" href="{{ url('/dashboard') }}">进入飞行员后台</a>
                            <a class="btn btn-danger" href="{{ url('/logout') }}">登出</a>
                        @else
                            <a class="btn btn-primary" href="{{ route('login') }}">@lang('auth.login')</a>

                            @if (Route::has('register'))
                                <a class="btn btn-secondary" href="{{ route('register') }}">@lang('auth.createaccount')</a>
                            @endif

                            @if (Route::has('password.request'))
                                <a class="btn btn-info" href="{{ route('password.request') }}">@lang('auth.forgotpassword')</a>
                            @endif
                        @endauth
                        <div class="col-lg-12 mx-auto my-3">
                            <input class="m-lg-3 search-input" placeholder="输入4位呼号或QQ号" type="text" name="callsign" id="callsign" value="" /> &nbsp;
                            <input type="button" name="button" class="btn btn-outline-light" id="queryStatus" value="查询呼号状态" />
                            <div class="m-0" style="color:lime;text-align:center;" id="searchResult">
                            </div>
                        </div>
                    </div>
                @else
                    <h1 class="text-warning">请移步<a href="//bbs.hkrscoc.com">新飞行员系统</a></h1>
                @endif
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        $(document).ready(function(){
            $('#queryStatus').click(function(e){
                e.preventDefault();
                let button = $(this);
                button.prop('disabled', true);
                let field = 'callsign';
                let callsign = $('#callsign').val();
                if(callsign.length > 4)
                {
                    field = 'icq';
                }
                $.ajaxSetup({
                    headers: {
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $('#searchResult').html('查询中...');
                $.ajax({
                    url: "{{ route('api.public.pilot.status') }}",
                    method: 'GET',
                    data: {
                        callsign: callsign, type: field,
                    },
                    success: function(result){
                        $('#searchResult').html(result.message);
                        button.prop('disabled', false);
                    },
                    error: function (jqXHR, status, err) {
                        let responseTxt = eval("(" + jqXHR.responseText + ")");
                        $('#searchResult').html('查询失败:' + responseTxt.message);
                        button.prop('disabled', false);
                    }});
            });
        });
    </script>
@endsection