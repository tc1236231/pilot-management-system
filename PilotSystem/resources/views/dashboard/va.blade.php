@extends('dashboard.layout')
@section('title')
    航空人生
@endsection
@section('page-name')
    航空人生
@endsection
@section('content')
    <div class="row p-3">
        <a class="btn btn-inverse-info" target="_blank" href="//va.hkonc.cn">进入航空人生首页</a>
    </div>
    @if($va == "notbinded")
        <div class="row">
            <div class="col-lg-12">
                <div class="card p-3">
                    {{ Form::open(['route' => 'frontend.dashboard.bindva', 'method' => 'post', 'class' => 'col-6']) }}
                    <div class="form-group">
                        {{ Form::label('callsign', '航空人生呼号:'.$user->callsign) }}
                    </div>
                    <div class="form-group">
                        {{ Form::label('password', '航空人生密码') }}
                        {{
                           Form::password('password', [
                               'name' => 'password',
                               'class' => 'form-control',
                               'placeholder' => '',
                               'required' => true,
                           ])
                        }}
                    </div>
                    {{ Form::submit('绑定', ['class' => "btn btn-success"]) }}
                    {{ Form::close() }}
                    <div class="col-6">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        @if (Session::has('status'))
                            <div class="alert  {{ Session::get('alert-class') }}">
                                {{ Session::get('status') }}
                            </div>
                        @endif
                        <div id="alert-ajax" class="alert alert-warning" style="display: none;">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @elseif($va == "dberror")
        <div class="row">
            <h5>数据库错误</h5>
        </div>
    @else
        <div class="row">
            <div class="col-lg-12">
                <div class="card p-3">
                    <div class="card-title">
                        航空人生绑定信息
                    </div>
                    <table class="table table-bordered table-dark">
                        <tr>
                            <td align="center">登陆编号</td>
                            <td align="center">航空公司</td>
                            <td align="center">呼号</td>
                            <td align="center">注册邮箱</td>
                            <td align="center">总航班数</td>
                            <td align="center">总飞行小时</td>
                            <td align="center">飞行员工资</td>
                            <td align="center">飞行等级</td>
                            <td align="center">充值余额</td>
                        </tr>
                        <tr>
                            <td align="center">CFR{{$va->pilotid}}</td>
                            <td align="center">{{$va->code}}</td>
                            <td align="center">{{$va->lastname}}</td>
                            <td align="center">{{$va->email}}</td>
                            <td align="center">{{$va->totalflights}}</td>
                            <td align="center">{{$va->totalhours}}</td>
                            <td align="center">{{$va->totalpay}}</td>
                            <td align="center">{{$va->rank}}</td>
                            <td align="center">{{$va->personaccount}}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    @endif
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