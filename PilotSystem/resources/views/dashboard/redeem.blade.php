@extends('dashboard.layout')
@section('title')
    货币兑换
@endsection
@section('page-name')
    货币兑换
@endsection
@section('content')
    <div class="row">
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
    </div>
    <div class="row mb-2">
        <div class="col-lg-12">
            <div class="card p-3">
                <div class="card-title">
                    飞行小时兑换货币
                </div>
                {{ Form::open(['route' => 'frontend.dashboard.redeemFlightHours', 'method' => 'POST', 'class' => 'col-12']) }}
                <div class="form-group">
                    <label>已兑换时长：{{ print_flight_time($user->xiaohaotime) }}</label>
                </div>
                <div class="form-group">
                    <label class="text-success">可兑换时长：{{ print_flight_time($user->onlinetime - $user->xiaohaotime) }}</label>
                    <label class="text-success">约为 {{ intval(($user->onlinetime - $user->xiaohaotime)/3600/5) }} 货币</label>
                </div>
                <div class="form-group">
                    {{ Form::label('quantity', '兑换货币数量 （汇率: 5小时兑换1货币)') }}
                    {{
                        Form::number('quantity', '0', [
                            'id' => 'quantity',
                            'class' => 'form-control col-4',
                            'required' => true,
                        ])
                    }}
                </div>
                {{ Form::submit('生成兑换码', ['class' => "btn btn-success"]) }}
                {{ Form::close() }}
            </div>
        </div>
    </div>
    <div class="row mt-3">
        <div class="col-lg-12">
            <div class="card p-3">
                <div class="card-title">
                    使用兑换码
                </div>
                {{ Form::open(['route' => 'frontend.dashboard.useRedeemCode', 'method' => 'post', 'class' => 'col-6']) }}
                <div class="form-group">
                    {{ Form::label('coupon', '选择兑换码') }}
                    <select name="coupon" class="form-control">
                        @foreach($coupons as $coupon)
                            <option value='{{ $coupon->privatekey }}'>{{ $coupon->amount }} | {{ $coupon->privatekey }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    {{ Form::label('platform', '选择入账平台') }}
                    <select name="platform" class="form-control">
                        @if(count($platforms) < 1)
                            <option value=''>无可兑换平台,请检查平台绑定信息</option>
                        @else
                            @foreach($platforms as $platform)
                                <option value='{{ $platform->code }}'>{{ $platform->name }}</option>
                            @endforeach
                        @endif
                    </select>
                </div>
                {{ Form::submit('兑换', ['class' => "btn btn-success"]) }}
                {{ Form::close() }}
            </div>
            <div class="card p-3">
                <div class="card-title">
                    兑换记录
                </div>
                @include('dashboard.log.redeem')
            </div>
        </div>
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
