@extends('base')
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
    <div class="flex-center position-ref full-height">
        <div class="content">
            <div class="title m-b-md">
                飞行员系统
            </div>
            @if (Route::has('login'))
                <div class="links">
                    @auth
                        <a class="btn btn-primary" href="{{ url('/dashboard') }}">进入飞行员后台</a>
                        <a class="btn btn-danger" href="{{ url('/logout') }}">登出</a>
                    @else
                        <a class="btn btn-secondary" href="{{ route('login') }}">@lang('auth.login')</a>

                        @if (Route::has('register'))
                            <a class="btn btn-secondary" href="{{ route('register') }}">@lang('auth.createaccount')</a>
                        @endif
                    @endauth
                </div>
            @endif
        </div>
    </div>
@endsection