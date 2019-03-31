@extends('dashboard.layout')
@section('title')
    个人信息
@endsection
@section('page-name')
    个人信息
@endsection
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card p-3">
                <div class="row">
                    {{ Form::open(['route' => 'frontend.dashboard.updateProfile', 'method' => 'PUT', 'class' => 'col-6 my-1']) }}
                    <p class="card-description mt-2">
                        个人信息
                    </p>
                    <div class="form-group">
                        {{ Form::label('realname', '真实姓名') }}
                        {{
                            Form::text('realname', $user->realname, [
                                'id' => 'realname',
                                'class' => 'form-control',
                                'required' => true,
                                'disabled' => $locked,
                            ])
                        }}
                    </div>
                    <div class="form-group">
                        {{ Form::label('phone', '手机号码') }}
                        {{
                            Form::text('phone', $user->phone, [
                                'id' => 'phone',
                                'class' => 'form-control',
                                'required' => true,
                                'disabled' => $locked,
                            ])
                        }}
                    </div>
                    <div class="form-group">
                        {{ Form::label('dizhi', '通讯地址') }}
                        {{
                            Form::text('dizhi', $user->dizhi, [
                                'id' => 'dizhi',
                                'class' => 'form-control',
                                'required' => true,
                                'disabled' => $locked,
                            ])
                        }}
                    </div>
                    @if (!$locked)
                        {{ Form::submit('绑定', ['class' => "btn btn-success"]) }}
                    @else
                        {{-- Form::submit('申请变更', ['class' => "btn btn-inverse-secondary"]) --}}
                    @endif
                    {{ Form::close() }}
                    <div class="col-6 my-1">
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
                            <div class="alert {{ Session::get('alert-class') }}">
                                {{ Session::get('status') }}
                            </div>
                        @endif
                        <h1 class="text-danger">注意</h1>
                        <h5 class="text-danger">手机号码（ 建议填支付宝账号 ）领取现金红包使用 | 通讯地址（ 建议填现所在地址 ）领取实物奖励收货使用 | 真实姓名（ 验证支付宝和邮寄使用 ）如果相关个人信息有变化，请及时登录飞行员系统，申请注册信息变更！ 请填写本页数据,降低呼号被清除概率! 兑换时因为信息错误，由个人承担！仅管理员可见,HTTPS加密放心填写。</h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <br />
    <div class="row">
        <div class="col-12">
            <div class="card">
                <table class="table table-bordered">
                    <tr>
                        <td align="center">ID</td>
                        <td align="center">操作人</td>
                        <td align="center">事件</td>
                        <td align="center">货币</td>
                        <td align="center">目标</td>
                        <td align="center">日期</td>
                    </tr>
                    @foreach($logs as $log)
                    <tr>
                        <td align="center">{{ $log->id }}</td>
                        <td align="center">{{ $log->callsign }}</td>
                        <td align="center">{{ $log->shijian }}</td>
                        <td align="center">{{ $log->huobi }}</td>
                        <td align="center">{{ $log->mubiao }}</td>
                        <td align="center">{{ $log->logdate }}</td>
                    </tr>
                    @endforeach
                </table>
                {{ $logs->links() }}
            </div>
        </div>
    </div>
    <br />
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