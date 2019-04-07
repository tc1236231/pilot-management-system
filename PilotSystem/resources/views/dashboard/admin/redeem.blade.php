@extends('dashboard.layout')
@section('head')
    <link rel="stylesheet" href="{{ asset('assets/css/jquery-ui.css') }}">
@endsection
@section('title')
    兑换生成
@endsection
@section('page-name')
    兑换生成
@endsection
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card p-3 col-12">
                {{ Form::open(['route' => 'frontend.dashboard.admin.createRedeem', 'method' => 'POST', 'class' => 'col-6 my-1']) }}
                <div class="form-group">
                    {{ Form::label('keybeizhu', '名称备注 (【活动名称】特殊事件说明 )') }}
                    {{
                        Form::text('keybeizhu', '', [
                            'id' => 'keybeizhu',
                            'class' => 'form-control',
                            'required' => true,
                        ])
                    }}
                </div>
                <div class="form-group">
                    {{ Form::label('huo_dong', '活动日期 (【活动日期】: 2017-12-02)') }}
                    {{
                        Form::datetime('huo_dong', '', [
                            'id' => 'huo_dong',
                            'class' => 'form-control datepicker',
                            'required' => true,
                        ])
                    }}
                </div>
                <div class="form-group">
                    {{ Form::label('cishu', '次数累加 ( 1 )') }}
                    {{
                        Form::number('cishu', '1', [
                            'id' => 'cishu',
                            'class' => 'form-control',
                            'required' => true,
                            'readonly' => true
                        ])
                    }}
                </div>
                <div class="form-group">
                    {{ Form::label('leixing', '呼号类型') }}
                    <select name="leixing" class="form-control">
                        <option type="text" name="" id="pilotleixing" value="1" selected>飞行员</option>
                        <option type="text" name="" id="atcleixing" value="2" >管制员</option>
                    </select>
                </div>
                <div class="form-group">
                    {{ Form::label('callsign_str', '呼号列表 (请用英文.号隔开,最后一位无.号) ') }}
                    {{
                        Form::text('callsign_str', '', [
                            'id' => 'callsign_str',
                            'class' => 'form-control',
                            'required' => true,
                        ])
                    }}
                </div>
                <div class="form-group">
                    {{ Form::label('val_price', '兑换面值') }}
                    {{
                        Form::number('val_price', '0', [
                            'id' => 'val_price',
                            'class' => 'form-control',
                            'required' => true,
                        ])
                    }}
                </div>
                {{ Form::submit('生成兑换码', ['class' => "btn btn-success"]) }}
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
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="card p-3 my-3">
            <div class="card-title">
                兑换日志
            </div>
            @include('dashboard.log.redeem')
        </div>
    </div>
@endsection
@section('script')
    <script src="{{ asset('assets/js/jquery-ui.js') }}"></script>
    <script src='{{ asset('assets/js/datepicker-zh-TW.js') }}'></script>
    <script>
        $("form").submit(function (e) {
            if ($(this).attr("attempted") === 'true' ) {
                e.preventDefault();
            }
            else {
                $(this).attr("attempted", 'true');
            }
        });
        $(".datepicker").datepicker();
        $(".datepicker").datepicker("option", "dateFormat", "yy-mm-dd");
    </script>
@endsection